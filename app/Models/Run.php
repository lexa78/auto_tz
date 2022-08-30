<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Run
 * @package App\Models
 */
class Run extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['km'];
}
