<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Year
 * @package App\Models
 */
class Year extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['year'];
}
