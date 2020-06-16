<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;

class DashboardController extends Controller
{
    const MAX_PICTURE_SIZE = 100 * 1024; // 100 KB
    const ALLOWED_PICTURE_EXTENSIONS = ['png', 'jpg', 'jpeg'];
    const ALLOWED_FILE_EXTENSIONS = ['pdf', 'png', 'jpg', 'jpeg'];
    const MAX_FILE_SIZE = 500 * 1024; // 500KB
    const MAX_FILE_NUM = 1;
    
    public function index()
    {
        $user = auth()->user();
        $type = $user->userable_type;
        $id = $user->id;
        if($user->userable_type!="admin"){
            $id = $user->userable_id;
        }
        if (
            $user->isNot('teacher') &&
            $user->isNot('student') &&
            !$user->isAdmin()
        ) {
            return redirect()->route('choose-account-type');
        }

        $method = 'show' . ucfirst($type ?? 'admin') . 'Dashboard';
        return $this->$method($id);
    }

    private function showAdminDashboard($id)
    {
        $tab = request()->query('tab');
        $tab = preg_match('/teachers|payments|editar/', $tab) ? $tab : 'teachers';
        $data = [];

        switch ($tab) {
            case 'teachers':
		$data['teachers'] = \App\Teacher::with('address','schedule','asigments','levels','categories')
						->orderBy('status')
						->get()
						->map(function ($teacher) {
						    return array_merge(
							$teacher->user->toArray(),
							$teacher->toArray()
						    );
						});
		break;

            case 'payments':
		$data['unpaidAsigments'] = \App\Asigment::with(
                    'teacher',
                    'level',
                    'category'
		)
							->where('status', 'finished')
							->get()
							->map(function ($asigment) {
							    $teacher = $asigment->teacher;
							    $user = $teacher->user;

							    $teacher->full_name = $user->full_name;
							    $teacher->avatar = $user->avatar;
							    $asigment->teacher = $teacher;
							    
							    return $asigment;
							});
		break;
	    case 'editar':
		$data['usuario'] = \App\User::findOrFail($id);
		break;
        }

        return view()->component(
            'dashboard.admin.index',
            ['title' => 'Dashboard', 'layout' => 'full-page'],
            ['tab' => $tab, 'data' => $data,'id'=>$id]
        );
    }
    public function editarAdmin($id,Request $request){
	
        
        $admin = \App\User::find($id);
        if(!Hash::check(request()->input('passworda'),$admin->password)){
            return "La contraseña actual es incorrecta";
        }else if(request()->input('password')!=request()->input('password1')){
            return "Las contraseñas no son iguales";
        }else{
            $admin->first_name = request()->input('first_name');
            $admin->last_name = request()->input('last_name');
            $admin->email = request()->input('email');
            $admin->password = Hash::make(request()->input('password'));
            $admin->save();
            return "pass";
        }
    }
    private function showStudentDashboard($id)
    {
        $user = auth()->user();
        $student = \App\Student::findOrFail($id);

        $asigments = \App\Asigment::where('student_id', $id)
				  ->where(function ($query) {
				      $query
                           ->where('status', 'evaluating')
                           ->orWhere('status', 'waiting-for-class');
				  })
				  ->get();

        $openAsigments = $asigments
                       ->filter(function ($asigment) {
                           return $asigment->status === 'evaluating';
                       })
                       ->map(function ($asigment) {
                           $asigment->invitations = $asigment
                                                  ->invitations()
                                                  ->where('status', 'accepted')
                                                  ->count();
                           return $asigment;
                       });

        $scheduledClasses = $asigments
                          ->filter(function ($asigment) {
                              return $asigment->status === 'waiting-for-class';
                          })
                          ->map(function ($asigment) {
                              $teacher = \App\Teacher::find($asigment->teacher_id);
                              $asigment->teacher = array_merge(
                                  $teacher->user->toArray(),
                                  $teacher->toArray()
                              );
                              return $asigment;
                          });

        $student = array_merge($user->toArray(), $student->toArray());

        return view()->component(
            'dashboard.student.index',
            ['title' => 'Dashboard'],
            compact('student', 'openAsigments', 'scheduledClasses')
        );
    }

    private function showTeacherDashboard($id)
    {
        $user = auth()->user();
        $teacher = \App\Teacher::findOrFail($id);

        if (!$teacher->answered_questions) {
            return redirect()->route('questions', 1);
        }

        $teacher->address;
        $teacher->schedule;
        $teacher = array_merge($user->toArray(), $teacher->toArray());

        $invitations = \App\Invitation::with('asigment')
				      ->where([['teacher_id', $id], ['status', 'pending']])
				      ->get();

        $scheduledClasses = \App\Asigment::with('level', 'category')
					 ->where([['teacher_id', $id], ['status', 'waiting-for-class']])
					 ->get();
        $classesFinish = \App\Asigment::with('level', 'category')
				      ->where([['teacher_id', $id], ['status', 'finished']])
				      ->get();
        $classesPaid = \App\Asigment::with('level', 'category','depositVoucher')
                       ->where([['teacher_id', $id], ['status', 'paid']])
                       ->get();
        $classesFinish = array_merge(
                                  $classesPaid->toArray(),
                                  $classesFinish->toArray()
                              );
        return view()->component(
		       'dashboard.teacher.index',
            ['title' => 'Dashboard'],
            compact('teacher', 'invitations', 'scheduledClasses','classesFinish')
        );
    }

    public function edit()
    {
        $user = auth()->user();

        if ($user->isNot('teacher')) {
            return redirect()->back();
        }

        $teacher = \App\Teacher::with(
        'levels',
        'categories',
        'address',
        'bank',
        )->findOrFail($user->userable_id);

        if (!$teacher->answered_questions) {
            return redirect()->route('questions', 1);
        }

        return view()->component(
            'dashboard.teacher.edit',
            ['title' => 'Editar'],
            [
		
            'MAX_FILE_SIZE' => $this::MAX_FILE_SIZE,
            'MAX_FILE_NUM' => $this::MAX_FILE_NUM,
            'MAX_PICTURE_SIZE' => $this::MAX_PICTURE_SIZE,
            'ALLOWED_FILE_EXTENSIONS' => $this::ALLOWED_FILE_EXTENSIONS,
            'ALLOWED_PICTURE_EXTENSIONS' =>
                    $this::ALLOWED_PICTURE_EXTENSIONS,
            'teacher' => array_merge($user->toArray(), $teacher->toArray()),
            'categories' => \DB::table('categories')->get(),
            'levels' => \DB::table('levels')->get(),
            'countries' => \DB::table('countries')
				  ->get()
				  ->map(function ($country) {
				      return [
	    'value' => $country->id,
	    'label' => $country->name,
	];
	}),
]
);
}
}
