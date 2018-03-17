<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialPage extends Model
{
    protected $fillable = ['name', 'type', 'markup'];

}
