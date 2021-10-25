<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
class AmbienceImage extends Model
{
    use LogsActivity;
    protected $table = 'ambience_images';
    protected static $logAttributes = ['*'];
}
