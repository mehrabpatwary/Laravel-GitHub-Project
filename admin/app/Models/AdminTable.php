<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminTable extends Model
{
    public $table='admin';
    public $primaryKey='id';
    public $incrementing=true;
    public $timestamps=false;
}
