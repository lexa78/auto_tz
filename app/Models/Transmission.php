<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transmission
 * @package App\Models
 */
class Transmission extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name'];
}
