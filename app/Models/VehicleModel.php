<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleModel
 * @package App\Models
 */
class VehicleModel extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'models';
    /**
     * @var string[]
     */
    protected $fillable = ['name'];
}
