<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    //
    protected $fillable = [
        'penerima_id', 'pengirim_id', 'saldo',
    ];
    public function penerima()
    {
        return $this->belongsTo('App\User','penerima_id');
    }
    public function pengirim()
    {
        return $this->belongsTo('App\User','pengirim_id');
    }
}
