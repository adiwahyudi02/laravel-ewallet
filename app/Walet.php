<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Walet extends Model
{
    protected $table = 'wallet';
    protected $fillable = ['user_id', 'saldo'];
}
