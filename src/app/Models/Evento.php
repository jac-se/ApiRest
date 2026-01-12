<?php

namespace App\Models;

// Modelo base de Eloquent
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    /**
     * ❌ ERROR QUE TENÍAS:
     * Usabas `protected $tabla`
     * Laravel NO reconoce esa propiedad.
     *
     * ✅ CORRECTO:
     * `$table` indica explícitamente el nombre de la tabla
     * en la base de datos.
     */
    protected $table = 'eventos';

    /**
     * `$fillable` define qué campos pueden ser asignados
     * de forma masiva (Evento::create()).
     *
     * ❌ ERROR QUE TENÍAS:
     * 'fcha_fin' estaba mal escrito
     * y no coincidía con:
     *  - la columna en la BD
     *  - el controller
     *  - el JSON del request
     *
     * Eso provocaba error 500 (MassAssignmentException).
     */
    protected $fillable = [
        'titulo',        // Título del evento
        'descripcion',   // Descripción del evento
        'fecha_inicio',  // Fecha de inicio (YYYY-MM-DD)
        'fecha_fin',     // Fecha de fin (YYYY-MM-DD)
        'ubicacion'      // Lugar o modalidad del evento
    ];

    /**
     * (Opcional)
     * Si tu tabla NO usa timestamps (created_at, updated_at)
     * descomenta la siguiente línea:
     */
    // public $timestamps = false;
}
