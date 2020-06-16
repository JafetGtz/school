<?php

namespace App\Http\Controllers;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Asigment;
use App\Teacher;
use App\Room;

class CheckoutController extends Controller
{
    private $api_context;

    public function __construct()
    {
        $this->api_context = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
        $this->api_context->setConfig(config('paypal.settings'));
    }

    public function index($id)
    {
        $asigment = Asigment::findOrFail($id);

        // If the asigment is already paid, redicrect to chat page
        if ($asigment->status === 'waiting-for-class') {
            return redirect()->route('room', $asigment);
        }

        $teacher_id = request()->query('teacher_id');

        // Make sure that teacher exist and was invitated to this asigment
        if (
            !$asigment
                ->invitations()
                ->where('teacher_id', $teacher_id)
                ->exists()
        ) {
            return redirect()->route('asigment.index', $id);
        }

        session()->put('teacher_id', $teacher_id);

        $error = session()->get('error');
        session()->forget('error');

        return view()->component(
            'checkout.index',
            ['title' => 'Abonar pago por servicio'],
            [
                'asigment' => $asigment,
                'error' => $error,
            ]
        );
    }

    public function success($id)
    {
        return view()->component(
            'checkout.success',
            ['title' => 'Pago exitoso'],
            ['asigment' => Asigment::findOrFail($id)]
        );
    }

    public function prepare($id)
    {
        $asigment = Asigment::findOrFail($id);
	
        $currency = config('app.currency_code');
        $tax = (float) config('app.service_tax');
        $budget = (float) $asigment->budget-3;
        $invoice_number = uniqid();
        $description = 'Clase online';
        $total = $budget + $tax;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item
            ->setName('Servicio de tutoría académica')
            ->setCurrency($currency)
            ->setQuantity(1)
            ->setPrice($budget);

        $tax_item = new Item();
        $tax_item
            ->setName('Uso de la plataforma')
            ->setCurrency($currency)
            ->setQuantity(1)
            ->setPrice($tax);

        $item_list = new ItemList();
        $item_list->setItems([$item, $tax_item]);

        // Create and setup the total amount.
        $amount = new Amount();
        $amount->setCurrency($currency)->setTotal($total);

        // Create a transaction and amount and description.
        $transaction = new Transaction();
        $transaction
            ->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($description)
            ->setInvoiceNumber($invoice_number);

        // Create a redirect urls, cancel url brings us back to current page, return url takes us to confirm payment.
        $redirect_urls = new RedirectUrls();
        $redirect_urls
            ->setReturnUrl(route('payment.execute', $asigment->id))
            ->setCancelUrl(route('checkout.index', $asigment->id));

        // We set up the payment with the payer, urls and transactions.
        $payment = new Payment();
        $payment
            ->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirect_urls);

        // Put the payment creation in try and catch in case of exceptions.
        try {
            $payment->create($this->api_context);
        } catch (Exception $e) {
            report($e);
            return $this->handleError($asigment->id);
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        if (isset($redirect_url)) {
            return redirect()->away($redirect_url);
        }

        return $this->handleError($asigment->id);
    }

    public function execute($id)
    {
        $request = request();

        // If query data not available... no payments was made.
        if (
            empty($request->query('paymentId')) ||
            empty($request->query('PayerID'))
        ) {
            return $this->handleError($id);
        }

        // We retrieve the payment from the paymentId.
        $payment = Payment::get(
            $request->query('paymentId'),
            $this->api_context
        );

        // We create a payment execution with the PayerId
        $execution = new PaymentExecution();
        $execution->setPayerId($request->query('PayerID'));

        try {
            // Then we execute the payment.
            $payment->execute($execution, $this->api_context);
        } catch (\Exception $e) {
            report($e);
            return $this->handleError($id);
        }

        $this->finish(Asigment::findOrFail($id), $payment);

        return redirect()->route('checkout.success', $id);
    }

    private function finish(Asigment $asigment, $payment)
    {
        // Store payment in database
        $asigment->payment()->create([
            'transaction_id' => $payment->getId(),
            'invoice_id' => $payment->transactions[0]->invoice_number,
            'amount' => $payment->transactions[0]->amount->total,
        ]);

        // Delete all related invitations, that way teachers that did'nt
        // respond to the invitation don't see the outdated invitation
        $asigment->invitations()->update(['status' => 'obsolete']);

        // Update asigment status
        $asigment->update([
            'status' => 'waiting-for-class',
            'teacher_id' => session()->get('teacher_id'),
        ]);

        // A accepted class notificacions is sent
        $teacher = $asigment->teacher->user->email; 
        $recipient = auth()->user();

        $emails = array($recipient,$teacher); 
        $mail = new \App\Mail\AcceptedClass();
        Mail::to('noresponder.mathias20@gmail.com')->bcc($emails)->queue($mail);
        
        session()->forget('teacher_id');

        // Send an email to user with the bill
        $this->sendBill($recipient, $payment);
    }

    private function sendBill($recipient, $payment)
    {
        $transaction = $payment->transactions[0];
        $payer = $payment->payer->payer_info;

        $items = [];

        foreach ($transaction->item_list->items as $item) {
            $items[] = [
                'name' => $item->name,
                'price' => $item->price,
                'currency' => $item->currency,
                'quantity' => $item->quantity,
            ];
        }

        $bill = [
            'payer' => [
                'first_name' => $payer->first_name,
                'last_name' => $payer->last_name,
            ],
            'invoice_number' => $payment->getId(),
            'items' => $items,
            'currency' => $transaction->amount->currency,
            'subtotal' => $transaction->amount->total,
            'total' => $transaction->amount->details->subtotal,
        ];

        Mail::to($recipient)->queue(new \App\Mail\Bill($bill));
    }

    private function handleError(
        $asigment_id,
        $message = 'Hubo un error al procesar su pago. Disculpe el inconveniente.'
    ) {
        session()->put('error', $message);
        return redirect()->route('checkout.index', $asigment_id);
    }
}
