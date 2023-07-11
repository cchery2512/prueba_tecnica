<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventoCalendario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'evento_calendario';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fecha_hora_inicio' => 'datetime',
        'fecha_hora_fin' => 'datetime'
    ];

    public function tipo_evento()
    {
        return $this->hasOne(TipoEvento::class, 'id', 'tipo_evento_id');
    }

    public function u_crea()
    {
        return $this->hasOne(User::class, 'id', 'usuario_crea');
    }

    public function u_modifica()
    {
        return $this->hasOne(User::class, 'id', 'usuario_modifica');
    }
}
