<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $fillable = [
        'id',
        'name',
    ];
=======
    protected $table='branches';
    protected $fillable=['name','description'];

>>>>>>> a2db677f1f9d2df68c7fd3c81ad04eb04dbacce0
}
