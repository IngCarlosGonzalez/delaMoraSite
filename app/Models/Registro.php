<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registro extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lafecha(): BelongsTo
    {
        return $this->belongsTo(Fecha::class, 'fecha');
    }

    public function nombre(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'empnum');
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
}
