<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fecha extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'fecha';

    public function registros(): HasMany
    {
        return $this->hasMany(Registro::class, 'fecha');
    }

}
