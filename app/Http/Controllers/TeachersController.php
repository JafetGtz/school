<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Hash;

class TeachersController extends Controller
{
    const MAX_PICTURE_SIZE = 100 * 1024; // 100 KB
    const ALLOWED_PICTURE_EXTENSIONS = ['png', 'jpg', 'jpeg'];
    const ALLOWED_DOCUMENT_EXTENSIONS = ['pdf', 'png', 'jpg', 'jpeg'];
    const ALLOWED_FILE_EXTENSIONS = ['pdf', 'png', 'jpg', 'jpeg'];
    const MAX_FILE_SIZE = 500 * 1024; // 500KB
    const MAX_FILE_NUM = 3;
    const TOTAL_STEPS = 4;
    
    
    public function update($id)
    {
        $image_mimes = implode(',', $this::ALLOWED_PICTURE_EXTENSIONS);
        $max_size = $this::MAX_PICTURE_SIZE / 1024;
        request()->validate(
            [
                'first_name' => ['required', 'string', 'min:4', 'max:25'],
                'last_name' => ['required', 'string', 'min:4', 'max:25'],
                'country_id' => 'required|numeric|exists:countries,id',
                'birthday' => 'required|date',

                // 'phone_prefix' => 'required|regex:/^(\+)([1-9]{2})$/',
                // 'phone' => 'phone:AUTO,' . implode(',', $codes),

                'address_country_id' => 'required|numeric|exists:countries,id',
                'address_city' => 'required|max:50',
                'address_line' => 'required|max:100',
                'address_zip_code' => 'required|max:10',
                'address_state' => 'required|max:50',

                'levels' => 'required|array:levels,id',
                'categories' => 'required|array:categories,id'
            ],
            [
                // 'phone_prefix.regex' =>
                //         'Debes suministrar un código de país valido.',
                'levels.required' =>
                    'Debes elegir al menos un nivel de educación',
                'categories.required' =>
                    'Deber elegir al menos una especialidad',
            ]
        );
        $teacher = \App\Teacher::findOrFail($id);
        $user =auth()->user();
        if(!Hash::check(request()->input('passa'),$user->password)){
            return "La contraseña actual es incorrecta";
        }else if(request()->input('pass1')!=request()->input('pass2')){
            return "Las contraseñas no son iguales";
        }else{
            if(request()->input('pass1')){
                $user->password = Hash::make(request()->input('pass1'));
            }
            $user->update(request()->only(['first_name', 'last_name','email']));
            $teacher->update(request()->only(['country_id', 'birthday']));
            
            //-------------------define address-----------------------------v
            $line = request()->address_line;
            $country = request()->address_country_id;
            $city = request()->address_city;
            $zip_code = request()->address_zip_code;
            $state = request()->address_state;
            
            //-------------------update address-----------------------------v
            $teacher->address()->update([
                'line'=>$line,
                'country_id'=> $country,
                'city'=>$city,
                'zip_code'=>$zip_code,
                'state'=>$state]);
            
            //-------------------update levels------------------------v
            $arrL = request()->input('levels');
            foreach($arrL as &$val){
                $numArray = array_map('intval', explode(',', $val));
            }
            $teacher->levels()->sync($numArray);
            
            
            //-------------------update categories------------------------v
            $arrL = request()->input('categories');
            foreach($arrL as &$val){
                $numArray = array_map('intval', explode(',', $val));
            }
            $teacher->categories()->sync($numArray);
            $teacher->save();
            
            //-----------------update avatar--------------------------------v
            if(request()->file('avatar')){
                $avatar = request()->file('avatar');
                $image_path = "avatars/{$user->id}.jpg";
                $image_full_path = storage_path("app/public/$image_path");
                
                Storage::makeDirectory('/avatars');
                
                \Image::make($avatar)
                    ->fit(216)
                    ->save($image_full_path, 75);
                
                $user->avatar = "/storage/$image_path";
            }
            
            //----------------update document----------------------------------v
            if(request()->file('filee')){
                $document = request()->file('filee');
                Storage::makeDirectory('/documents');
                
                $document_path = $document->store('documents');
                $teacher->document = $document_path;
            }
            $teacher->save();
            $user->save();
            return "pass";
            
            /* $teacher->bank()->updateOrCreate(request()->input('bank'));*/
        }
        
    }
    
    public function updateSchedule($id)
    {
        $teacher = \App\Teacher::findOrfail($id);
        $new_schedule = [];

        foreach (request()->input('schedule') as $key => $value) {
	    if (count($value)) {
                foreach ($value as $range) {
		    [$start, $end] = $range;
		    $new_schedule[] = [
                        'start' => "$start:00:00",
                        'end' => "$end:00:00",
                        'day_of_week' => $key,
		    ];
                }
	    }
        }

        $teacher->schedule()->delete();
        $teacher->schedule()->createMany($new_schedule);
    }

    public function updateStatus($id)
    {
        $teacher = \App\Teacher::findOrFail($id);
        $teacher->status = request()->input('status');
        $teacher->save();
    }
}
