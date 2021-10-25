<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

use Spatie\Activitylog\Traits\LogsActivity;

class Config extends Model
{
    use Notifiable, LogsActivity;

    protected $table = 'configs';
    /* set--Nomedainput--Attribute
     respeitando o case-sensitive
    */
    public function setTitleAttribute($value)
    {
        $this->attributes['title']=$value;
        $this->attributes['slug']=Str::slug($value);
    }
    public function addresses()
    {
        return $this->hasMany(ConfigAddress::class,'config_id','id');
    }

    protected $fillable = [
        'title', 'email', 'favicon',
    ];

    /*
    |Registra como LOG o que foi alterado
    | todos atributos alterados -> $logAttributes = ['*']
    | Somente os atributos selecionados ->  $logAttributes = ['name','email','etc']
    */
    protected static $logAttributes = ['*'];


}
