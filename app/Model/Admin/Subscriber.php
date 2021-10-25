<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Subscriber extends Model
{
    use LogsActivity;

    protected $table = 'subscribers';
    protected static $logAttributes = ['*'];
    /* set--Nomedainput--Attribute
     respeitando o case-sensitive
    */
    protected $fillable = [
        'id', 'active', 'email','deleted_because', 'deleted_by', 'created_by'
    ];

    protected $dates = [
        'deleted_at','created_at', 'updated_at'
    ];
}
