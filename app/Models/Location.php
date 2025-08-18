<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    // 隣接する拠点を取得
    public function neighbors()
    {
        return $this->hasMany(LocationConnection::class, 'from_location_code', 'code')
            ->with('toLocation');
    }

    // 接続先の Location
    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_code', 'code');
    }
}