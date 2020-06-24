<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    protected $primaryKey = ['mal_user_id', 'mal_series_id'];
    public $incrementing = false;
}
