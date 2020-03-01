<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;



/**
 * Class Ship
 *
 * @property string            $code
 * @property string            $model
 * @property string            $type
 * @property Crew[]|Collection $crews
 * @property Ship[]|Collection $subordinates
 */


class Ship extends Model
{
    protected $fillable = ['code', 'model', 'type', 'commander_id'];


    public function crews()
    {
        return $this->hasMany(Crew::class);
    }

    public function subordinates()
    {
        return $this->hasMany(Ship::class, 'commander_id');
    }

    public function commander()
    {
        return $this->belongsTo(Ship::class, 'id', 'commander_id');
    }

}
