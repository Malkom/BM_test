<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 16/12/2018
 * Time: 19:52
 */

namespace Bloom\DeathStarsManagement\Data;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ship
 * @package Bloom\DeathStarsManagement\Data
 *
 * @property string $code
 * @property string $model
 * @property string $type
 * @property Crew[]|Collection $crews
 * @property Ship[]|Collection $subordinates
 */
class Ship extends Model
{


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