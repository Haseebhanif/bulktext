<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailService extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name','email','username','password','smtp','port','encryption','tenant_id'];
}
