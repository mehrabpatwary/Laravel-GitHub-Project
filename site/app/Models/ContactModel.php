<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    public $table='contact';
    public $primaryKey='id';
    public $incrementing=true;
    public $timestamps=false;
}
