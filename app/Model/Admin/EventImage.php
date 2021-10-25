<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
class EventImage extends Model
{
    use LogsActivity;
    protected $table = 'event_images';
    protected static $logAttributes = ['*'];
}
