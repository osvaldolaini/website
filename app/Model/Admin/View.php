<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
class View extends Model
{
    use LogsActivity;

    protected $table = 'views';
    protected static $logAttributes = ['*'];

    protected $fillable = [
        'id', 'page', 'user_device', 'user_ua',
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
