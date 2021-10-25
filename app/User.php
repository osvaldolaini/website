<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Auth;

use App\Model\Admin\UserGroups;

use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, LogsActivity;

    protected $table = 'users';

    public function group()
    {
        return $this->belongsTo(UserGroups::class,'group_id','id');
    }
    /*
    |Registra como LOG o que foi alterado
    | todos atributos alterados -> $logAttributes = ['*']
    | Somente os atributos selecionados ->  $logAttributes = ['name','email','etc']
    */
    protected static $logAttributes = [
        'name', 'email','active','group_id'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
        public function adminlte_image()
        {
            if(Auth::user()->image){
                $user=Auth::user()->image;
                return url('storage/images/users/'.$user);
            }else{
                return url('storage/images/logos/logo.png');
            }

        }

        public function adminlte_desc()
        {
            return Auth::user()->group->title;
        }

        public function adminlte_profile_url()
        {
            return 'usuarios/'.Auth::user()->id.'/editar';
        }
}
