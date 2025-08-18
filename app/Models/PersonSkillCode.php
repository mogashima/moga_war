<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonSkillCode extends Model
{
    protected $fillable = [
        'person_code',
        'skill_code',
    ];
}
