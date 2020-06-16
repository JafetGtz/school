<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            border: 0;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
        }

        .wrapper {
            width: 80%;
            margin: 0 auto;
            padding: 5rem 0;
        }

        h1 {
            text-transform: uppercase;
            color: #4dccbd;
         }

         .banner {
             background: #4dccbd;
             padding: 2rem;
             border-radius: 10px;
             color: white;
             margin-bottom: 2rem;
         }

        .banner h2 {
            color: white;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: inherit;
        }

        table thead {
            border-bottom: 2px solid black;
            text-transform: uppercase;
            font-weight: bold;
            text-align: left;
        }

        thead th:last-child,
        tbody td:last-child,
        tfoot td:last-child {
            text-align: right;
        }

        tbody td { border-bottom: 1px solid black }

        tbody td,
        thead th {
            padding: 0.5rem 1rem;
        }

        table tfoot { border-top: 2px solid black }

        tfoot td { padding: 0 1rem }

        tfoot tr:first-child td {
            padding-top: 1rem;
        }

        tfoot td:first-child {
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
        }

        tfoot tr:last-child td {
            text-transform: uppercase;
            padding-top: 0.5rem;
            font-size: 1.75rem;
        }
    </style>
</head>
<body>

    <div class="wrapper">

        <h1>{{ config('app.name') }}</h1>

        <div class="banner">
            <h2>{{ $payer['first_name'] }}, gracias por elegirnos.</h2>
            <p>Revisa tu factura. La confirmación del pago de tu servicio es:</p>
        </div>

        <h3>Número de pedido: {{ $invoice_number }}</h3>

        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['quantity']}}</td>
                        <td>{{$item['currency']}} {{$item['price']}}</td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2">Subtotal:</td>
                    <td>{{ $currency }} {{ $subtotal }}</td>
                </tr>

                <tr>
                    <td colspan="2">Impuesto:</td>
                    <td>{{ $currency }} 0.00</td>
                </tr>

                <tr>
                    <td colspan="2">Total:</td>
                    <td>{{ $currency }} {{ $total }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>
