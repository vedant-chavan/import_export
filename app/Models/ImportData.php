<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportData extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
