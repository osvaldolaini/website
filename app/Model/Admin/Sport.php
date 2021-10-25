<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
class Sport extends Model
{
    use LogsActivity;

    protected $table = 'sports';
    protected static $logAttributes = ['*'];

    /* set--Nomedainput--Attribute
     respeitando o case-sensitive
    */
    public function setTitleAttribute($value)
    {
        $this->attributes['title']=mb_strtoupper($value);
        $this->attributes['slug']=Str::slug($value);

        $tags = str_replace('-', '; ', Str::slug($value));
        $this->attributes['tags']= 'ASSGAPA; CSSGAPA; Clube em Canoas; '. $tags;
    }

    protected $fillable = [
        'id', 'active', 'title', 'slug', 'link', 'image', 'description','responsible','clicks','tags',
        'phone', 'whatsapp', 'telegram', 'facebook', 'instagram', 'twitter', 'youtube', 'email',
        'updated_because', 'deleted_because', 'deleted_by',
        'updated_by', 'created_by'
    ];

    protected $dates = [
        'deleted_at','created_at', 'updated_at'
    ];
    public function images()
    {
        return $this->hasMany(SportImage::class,'sport_id','id');
    }
}
