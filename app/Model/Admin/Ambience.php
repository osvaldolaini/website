<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
class Ambience extends Model
{
    use LogsActivity;

    protected $table = 'ambiences';
    protected static $logAttributes = ['*'];
    /* set--Nomedainput--Attribute
     respeitando o case-sensitive
    */
    public function setTitleAttribute($value)
    {
        $this->attributes['title']=mb_strtoupper($value);
        $this->attributes['slug']=Str::slug($value);

        $this->attributes['tags']= 'ASSGAPA, CSSGAPA, salao, festas, espaco, eventos, 15 anos, casamentos, ';
    }
    protected $fillable = [
        'id', 'active', 'title', 'slug', 'description', 'clicks','tags',
        'updated_because', 'deleted_because', 'deleted_by',
        'updated_by', 'created_by'
    ];

    protected $dates = [
        'deleted_at','created_at', 'updated_at'
    ];
    public function images()
    {
        return $this->hasMany(AmbienceImage::class,'ambience_id','id');
    }
}
