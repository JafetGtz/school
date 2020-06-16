<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Propaganistas\LaravelPhone\PhoneNumber;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'avatar',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'is_admin' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhoneAttribute()
    {
        if ($phone = $this->attributes['phone']) {
            try {
                $phone = PhoneNumber::make($phone)->formatInternational();
            } catch (\Throwable $th) {
                report($th);
            }
        }

        return $phone;
    }

    public function is($type)
    {
        return $this->attributes['userable_type'] === $type ||
            ($type === 'admin' && $this->attributes['is_admin']);
    }

    public function isNot($type)
    {
        return $this->attributes['userable_type'] !== $type;
    }

    public function isAdmin()
    {
        return !!$this->attributes['is_admin'];
    }

    public function userable()
    {
        return $this->morphTo();
    }
}
