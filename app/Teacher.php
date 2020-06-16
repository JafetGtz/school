<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Teacher extends Model
{

    public $timestamps = false;

    protected $fillable = ['document', 'birthday', 'answered_questions'];

    protected $casts = ['birthday' => 'date'];

    protected $appends = ['formatted_birthday', 'stars', 'scores'];

    public function getFormattedBirthdayAttribute()
    {
        $date = $this->attributes['birthday'];
        return Carbon::create($date)->isoFormat('D \d\e MMMM, YYYY');
    }

    public function getStarsAttribute()
    {
        return $this->rates->avg('score') ?? 0;
    }

    public function getScoresAttribute()
    {
        $scores = [];
        $criterias = \DB::table('criterias')->get();
        $rates = $this->rates;

        foreach ($criterias as $key) {
            $criteria_scores = $rates->filter(function ($row) use ($key) {
                return $row->criteria_id === $key->id;
            });

            $average = $criteria_scores->average('score') ?? 0;

            $scores[$key->name] = number_format($average, 1);
        }

        return $scores;
    }

    

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
    public function asigments()
    {
        return $this->hasMany(Asigment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function bank()
    {
        return $this->hasOne(Bank::class);
    }
}
