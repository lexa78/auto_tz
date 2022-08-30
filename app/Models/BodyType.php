<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BodyType
 * @package App\Models
 */
class BodyType extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name'];
}
