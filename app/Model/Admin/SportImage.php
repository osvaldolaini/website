<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
class SportImage extends Model
{
    use LogsActivity;
    protected $table = 'sport_images';
    protected static $logAttributes = ['*'];
}
