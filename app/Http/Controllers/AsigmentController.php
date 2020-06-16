<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Propaganistas\LaravelPhone\PhoneNumber;
use Carbon\Carbon;
use App\Asigment;
use App\Teacher;
use App\Invitation;
use Illuminate\Notifications\Notifiable;

class AsigmentController extends Controller
{
    const ALLOWED_FILE_EXTENSIONS = ['pdf', 'png', 'jpg', 'jpeg'];
    const MAX_FILE_SIZE = 500 * 1024; // 500KB
    const MAX_FILE_NUM = 3;
    const MIN_BUDGET = 5; // $ 5.00

    public function create()
    {
        return view()->component(
            'asigment.create',
            ['title' => 'Nueva propuesta'],
            [
                'levels' => \DB::table('levels')->get(),
                'categories' => \DB::table('categories')->get(),
                'ALLOWED_FILE_EXTENSIONS' => $this::ALLOWED_FILE_EXTENSIONS,
                'MAX_FILE_SIZE' => $this::MAX_FILE_SIZE,
                'MAX_FILE_NUM' => $this::MAX_FILE_NUM,
            ]
        );
    }

    public function index($id)
    {
        $asigment = Asigment::with('level', 'category', 'files')->findOrFail(
            $id
        );

        // the user need see how many teachers has been invited.
        $count = Invitation::where('asigment_id', '=',$id)->count();

        switch ($asigment->status) {
            case 'waiting-for-class':
                return redirect()->route('room', $id);
            case 'finished':
            case 'canceled':
                return redirect()->route('asigment.create');
        }

        $available_teachers = \App\Teacher::select(
            'u.first_name as first_name',
            'u.last_name as last_name',
            'u.avatar as avatar',
            'teachers.*'
        )
					  ->join('invitations as i', function ($join) use ($id) {
					      $join
                    ->on('i.teacher_id', 'teachers.id')
                    ->where('i.asigment_id', '=', $id)
                    ->where('i.status', '=', 'accepted');
					  })
					  ->join('users as u', function ($join) {
					      $join
                    ->on('u.userable_id', 'teachers.id')
                    ->where('u.userable_type', '=', 'teacher');
					  })
					  ->get();

        return view()->component(
            'asigment.index',
            ['title' => 'Propuesta'],
            [
                'asigment' => $asigment,
                'teachers' => $available_teachers,
                'isNew' => request()->query('is-new', '0'),
                'count' => $count,
            ]
        );
    }

    public function store()
    {
        $this->validator()->validate();

        $data = request()->only([
            'budget',
            'details',
            'date',
            'level_id',
            'category_id',
	    'hours',
        ]);

        $data['date'] = Carbon::parse($data['date']);
        $data['student_id'] = auth()->user()->userable->id;
        $asigment = Asigment::create($data);

        try {
            $this->storeAttachments($asigment);
            $this->inviteTeachers($asigment);
        } catch (\Throwable $th) {
            $this->deleteAttachments($asigment);
            $asigment->delete();
            throw $th;
        }

        return $asigment->id;
    }

    
    public function storeDepositVoucher($id)
    {
        request()->validate([
            'file' =>
                'required|mimes:' .
                    implode(',', $this::ALLOWED_FILE_EXTENSIONS),
        ]);

        $asigment = \App\Asigment::findOrFail($id);

        $file = request()->file('file');
        $filename = $file->store('/vouchers');
        $path = "/storage/$filename";

        $asigment->update(['status' => 'paid']);
        $asigment->depositVoucher()->create(['path' => $path]);
    }

    //The user's can edit their propositions 
    public function edit($id)
    {   

	/*  $this->validator()->validate(); */

        $asigment = Asigment::with('level', 'category', 'files')->findOrFail(
            $id
        );

        return view()->component(
            'asigment.edit',
            ['title' => 'Edita tu propuesta'],
            [
                'levels' => \DB::table('levels')->get(),
                'categories' => \DB::table('categories')->get(),
                'ALLOWED_FILE_EXTENSIONS' => $this::ALLOWED_FILE_EXTENSIONS,
                'MAX_FILE_SIZE' => $this::MAX_FILE_SIZE,
                'MAX_FILE_NUM' => $this::MAX_FILE_NUM,
                'assignment' => $asigment, 
            ],
        );
    }

    /* The function not delete files
       For the future: need other format for show files.
       The format for save is that the html type=change return.
     */

    public function editStore($id){
        $assignment = \App\Asigment::find($id);

        $data = request()->only([
            'budget',
            'details',
            'date',
            'level_id',
            'category_id',
            'hours',
            'files'
        ]);


        $assignment->update([
            'date' => Carbon::parse($data['date']),
            'details' => $data['details'],
            'level_id' => $data['level_id'],
            'category_id' => $data['category_id'],
            'hours' => (int)$data['hours'],
            'budget' => $data['budget']
        ]);

        
        try {
                //The invitation will create again
                $assignment->invitations()->delete();
                $this->storeAttachments($assignment);
                $this->inviteTeachers($assignment);
        }   catch (\Throwable $th) {
                $this->deleteAttachments($assignment);
                $assignment->delete();
                throw $th;
        }

        /* $this->storeAttachments($assignment); */

    }

    public function delete($id)
    {
        $asigment = Asigment::findOrFail($id);
        $asigment->status = 'canceled';
        $emails = [];
        foreach (
            $asigment
                ->invitations()
                ->where('status', 'accepted')
                ->get()
            as $invitation
        ) {
            $receipt = $invitation->teacher->user;
            array_push($emails, $receipt->email);
        }
        $mail = new \App\Mail\CanceledNotification();

        try {
            Mail::to('noresponder.mathias20@gmail.com')->bcc($emails)->queue($mail);
        } catch (\Throwable $th) {
            report($th);
        }

        $asigment->invitations()->update(['status' => 'canceled']);
        $asigment->save();

        $this->deleteAttachments($asigment);

        return;
    }


    // class finished
    public function finish($id)
    {
        $asigment = Asigment::findOrFail($id);
        $asigment->status = 'finished';
        $asigment->invitations()->update(['status' => 'canceled']);
        $asigment->save();
	$this->deleteAttachments($asigment);
        return;
    }



    
    // Store in disk all files uploaded by user one by one
    // and at the same time store file details in database

    private function storeAttachments(Asigment $asigment)
    {
        $folder = "attachments/{$asigment->id}";

        foreach (request()->file('files') as $file) {
            if (!$file->isValid()) {
                continue;
            }

            // TODO: if the file is an image we should compress it
            $filename = $file->store($folder);
            $path = "/storage/$filename";

            $asigment->files()->create([
                'name' => $file->getClientOriginalName(),
                'type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'path' => $path,
            ]);
        }
    }

    private function deleteAttachments(Asigment $asigment)
    {
        $folder = "attachments/{$asigment->id}";
        Storage::deleteDirectory($folder);  
    }

    // Query the database to find all teachers that
    // match with the asigment level, category and time
    // of the asigment and mail then an invitation

    private function inviteTeachers(Asigment $asigment)
    {
        // This is the number of minutes of a class session
        // Theacer should not be invited if they accepted
        // another invitation to a class appointed to the same
        // day and hour
        $max_minutes = 60;

        $level_id = $asigment->level_id;
        $category_id = $asigment->category_id;

        $date = Carbon::parse($asigment->date);
        $day_of_week = ((int) $date->dayOfWeek) + 1;
        $year = $date->year;
        $time = $date->format('H:i');

        $matched_teachers = \DB::table('teachers as t')
			       ->select('t.id as id', 'u.email as email')
			       ->distinct()
			       ->join('users as u', function ($join) {
				   $join
                    ->on('u.userable_id', '=', 't.id')
                    ->where('u.userable_type', 'teacher');
			       })
			       ->join('level_teacher as l_t', 't.id', '=', 'l_t.teacher_id')
			       ->join('category_teacher as c_t', 't.id', '=', 'c_t.teacher_id')
			       ->join('schedules as s', 't.id', '=', 's.teacher_id')
			       ->leftJoin('invitations as i', 't.id', '=', 'i.teacher_id')
			       ->leftJoin('asigments as a', 'a.id', '=', 'i.asigment_id')
			       ->where([
				   ['t.status', '=', 'active'],
				   ['l_t.level_id', '=', $level_id],
				   ['c_t.category_id', '=', $category_id],
				   ['s.start', '<=', $time],
				   ['s.end', '>=', $time],
				   ['s.day_of_week', '=', $day_of_week],
			       ])
			       ->where(function ($query) use (
				   $max_minutes,
				   $day_of_week,
				   $year,
				   $time
			       ) {
				   $query
                    ->whereNull('a.id')
                    ->orWhere('i.status', '<>', 'accepted')
                    ->orWhere(function ($query) use (
                        $max_minutes,
                        $day_of_week,
                        $year,
                        $time
                    ) {
                        $query
                            ->whereRaw("DAYOFWEEK(a.date) <> $day_of_week")
                            ->orWhereRaw("YEAR(a.date) <> $year")
                            ->orWhereRaw(
                                "TIME(DATE_ADD(a.date, INTERVAL $max_minutes MINUTE)) <= '$time'"
                            )
                            ->orWhereRaw(
                                "TIME(DATE_SUB(a.date, INTERVAL $max_minutes MINUTE)) >= '$time'"
                            );
                    });
			       })
			       ->get();

        if ($matched_teachers->isEmpty()) {
            return;
        }
        // Now create invitations in database
        $emails = [];
        $invitations = [];
        $mail = new \App\Mail\Invitation($asigment);
        foreach ($matched_teachers as $teacher) {
            $invitations[] = [
                'asigment_id' => $asigment->id,
                'teacher_id' => $teacher->id,
            ];
            array_push($emails, $teacher->email);
        }
        try {
            Mail::to('noresponder.mathias20@gmail.com')->bcc($emails)->queue($mail);
        } catch (\Throwable $th) {
            report($th);
        }

        $asigment->invitations()->createMany($invitations);
    }

    public function validator()
    {
        $codes = \DB::table('countries')
		    ->select('code')
		    ->get()
		    ->map(function ($country) {
			return $country->code;
		    })
		    ->toArray();

        $rules = [
            'budget' => 'required|numeric|min:' . $this::MIN_BUDGET,
            'details' => 'required|max:300|min:25',
            'level_id' => 'required|exists:levels,id',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'files' => 'required|array|min:1|max:' . $this::MAX_FILE_NUM,
            'files.*' =>
                'mimes:' .
                       implode(',', $this::ALLOWED_FILE_EXTENSIONS) .
                       '|max:' .
                       $this::MAX_FILE_SIZE / 1024,
        ];

        $messages = [
            'budget.min' => 'El presupuesto mínimo es de $' . $this::MIN_BUDGET,
            'level_id.required' => 'Debes elegir el nivel de educación.',
            'category_id.required' => 'Debes elegir una materia.',
            // 'date.after' => 'La fecha debe ser un día y hora en el futuro.',
            'files.required' =>
                'Debes adjuntar al menos un archivo relacionado.',
            'files.min' => 'Debes adjuntar al menos un archivo relacionado.',
            'files.max' =>
                'No puedes adjuntar mas de ' .
			 $this::MAX_FILE_NUM .
			 'archivos.',
        ];

        return Validator::make(request()->all(), $rules, $messages);
    }
}

