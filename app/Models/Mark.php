<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mark
 * @package App\Models
 */
class Mark extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name'];
}
