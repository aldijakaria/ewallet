<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','saldo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function saldo(){
      $masuk= Transfer::where('penerima_id','=',Auth::user()->id)->sum('saldo');
      $keluar= Transfer::where('pengirim_id','=',Auth::user()->id)->sum('saldo');
      return $this->saldo+$masuk-$keluar;
    }
}
