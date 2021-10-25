<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class Email extends Model
{
    use LogsActivity;

    protected $table = 'emails';
    protected static $logAttributes = ['*'];
    /* set--Nomedainput--Attribute
     respeitando o case-sensitive
    */
    protected $fillable = [
        'id', 'active', 'message', 'answer','subject','from','updated_because', 'deleted_because', 'deleted_by', 'updated_by', 'created_by'
    ];

    protected $dates = [
        'deleted_at','created_at', 'updated_at'
    ];
}
