<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klub extends Model
{
    use HasFactory;

    protected $table = 'tbl_klub';


    protected $fillable = ["nama_klub", "kota_klub"];
}
