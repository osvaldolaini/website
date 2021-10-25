<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class SocialMedia extends Model
{
    use LogsActivity;

    protected $table = 'social_media';
    protected static $logAttributes = ['*'];
    /* set--Nomedainput--Attribute
     respeitando o case-sensitive
    */
    protected $fillable = [
        'id', 'active', 'title', 'link','updated_because', 'deleted_because', 'deleted_by', 'updated_by', 'created_by'
    ];

    protected $dates = [
        'deleted_at','created_at', 'updated_at'
    ];

}
