<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class ConfigAddress extends Model
{
    use LogsActivity;

    protected $table = 'configs_addresses';

    public function config()
    {
        return $this->belongsTo(Config::class,'config_id','id');
    }
    /*
    |Registra como LOG o que foi alterado
    | todos atributos alterados -> $logAttributes = ['*']
    | Somente os atributos selecionados ->  $logAttributes = ['name','email','etc']
    */
    protected static $logAttributes = ['*'];
}
