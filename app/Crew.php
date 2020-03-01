<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Crew
 *
 * @property string $code
 * @property string $name
 * @property string $job
 */

class Crew extends Model
{
    protected $fillable = ['code', 'name', 'job'];

}
