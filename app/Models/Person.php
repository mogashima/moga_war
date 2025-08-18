<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'person_skill_codes', 'person_code', 'skill_code', 'code', 'code');
    }
}
