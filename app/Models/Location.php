<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'pos_x', 'pos_y', 'faction_code'];

    public function people()
    {
        return $this->hasMany(Person::class, 'location_code', 'code');
    }

    public function faction()
    {
        return $this->belongsTo(Faction::class, 'faction_code', 'code');
    }
}