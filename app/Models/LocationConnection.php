<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LocationConnection extends Pivot
{
    protected $table = 'location_connections';
    protected $fillable = ['from_location_code', 'to_location_code'];

    // 接続先 Location
    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_code', 'code');
    }

    // 接続元 Location（必要に応じて）
    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_code', 'code');
    }
}