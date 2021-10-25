<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
class Covenant extends Model
{
    use LogsActivity;

    protected $table = 'covenants';
    protected static $logAttributes = ['*'];
    /* set--Nomedainput--Attribute
     respeitando o case-sensitive
    */
    public function setTitleAttribute($value)
    {
        $this->attributes['title']=mb_strtoupper($value);
        $this->attributes['slug']=Str::slug($value);

        $tags = str_replace('-', ', ', Str::slug($value));
        $this->attributes['tags']= 'ASSGAPA, CSSGAPA, Clube em Canoas, avioes, salao, festas, espaco, eventos, 15 anos, casamentos, aluguel, '. $tags;
    }
    protected $fillable = [
        'id', 'active', 'title', 'slug', 'link', 'image', 'description', 'address','clicks','tags',
        'phone', 'whatsapp', 'telegram', 'facebook', 'instagram', 'twitter', 'youtube', 'email',
        'updated_because', 'deleted_because', 'deleted_by',
        'updated_by', 'created_by'
    ];

    protected $dates = [
        'deleted_at','created_at', 'updated_at'
    ];

}
