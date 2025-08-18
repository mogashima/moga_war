<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'type',
        'power',
        'cost',
        'description',
    ];

    public function peopleByCode()
    {
        return $this->belongsToMany(Person::class, 'person_skill_code', 'skill_code', 'person_code', 'code', 'code');
    }
}