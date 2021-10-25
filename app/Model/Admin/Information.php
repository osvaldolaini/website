<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
class Information extends Model
{
    use LogsActivity;

    protected $table = 'information';
    protected static $logAttributes = ['*'];

    protected $fillable = [
        'id', 'active', 'title', 'clicks', 'description',
        'updated_because', 'deleted_because', 'deleted_by',
        'updated_by', 'created_by'
    ];

    protected $dates = [
        'deleted_at','created_at', 'updated_at'
    ];
}
