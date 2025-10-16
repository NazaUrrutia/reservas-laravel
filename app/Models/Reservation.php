<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Reservation extends Model
{
    use HasFactory;

    // Estados válidos
    const STATE_RESERVED = 'RESERVED';
    const STATE_SCHEDULED = 'SCHEDULED';
    const STATE_INSTALLED = 'INSTALLED';
    const STATE_UNINSTALLED = 'UNINSTALLED';
    const STATE_CANCELED = 'CANCELED';

    // Estados finales
    const FINAL_STATES = [self::STATE_CANCELED, self::STATE_UNINSTALLED];

    // Transiciones válidas
    const VALID_TRANSITIONS = [
        self::STATE_RESERVED => [self::STATE_SCHEDULED, self::STATE_CANCELED],
        self::STATE_SCHEDULED => [self::STATE_INSTALLED, self::STATE_CANCELED],
        self::STATE_INSTALLED => [self::STATE_UNINSTALLED],
    ];

    protected $fillable = [
        'name',
        'created_by',
        'address',
        'lat',
        'lng',
        'state',
    ];

    protected $casts = [
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'state' => self::STATE_RESERVED,
    ];

    /**
     * Verifica si una transición de estado es válida
     */
    public function canTransitionTo(string $newState): bool
    {
        // Si el estado actual es final, no puede cambiar
        if (in_array($this->state, self::FINAL_STATES)) {
            return false;
        }

        // Verifica si la transición está permitida
        return isset(self::VALID_TRANSITIONS[$this->state]) &&
               in_array($newState, self::VALID_TRANSITIONS[$this->state]);
    }

    /**
     * Cambia el estado si la transición es válida
     */
    public function changeState(string $newState): bool
    {
        if (!$this->canTransitionTo($newState)) {
            throw ValidationException::withMessages([
                'state' => ["No se puede cambiar de {$this->state} a {$newState}"]
            ]);
        }

        $this->state = $newState;
        return $this->save();
    }

    /**
     * Scope para filtrar por texto (busca en name, address, created_by)
     */
    public function scopeSearch($query, $searchTerm)
    {
        if ($searchTerm) {
            return $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('address', 'like', "%{$searchTerm}%")
                  ->orWhere('created_by', 'like', "%{$searchTerm}%");
            });
        }
        return $query;
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeByState($query, $state)
    {
        if ($state) {
            return $query->where('state', $state);
        }
        return $query;
    }

    /**
     * Scope para filtrar por creador
     */
    public function scopeByCreator($query, $createdBy)
    {
        if ($createdBy) {
            return $query->where('created_by', $createdBy);
        }
        return $query;
    }

    /**
     * Scope para filtrar por radio geográfico
     * Usa la fórmula de Haversine para calcular distancia
     */
    public function scopeNearLocation($query, $lat, $lng, $radiusKm)
    {
        if ($lat !== null && $lng !== null && $radiusKm !== null) {
            $earthRadius = 6371; // Radio de la Tierra en km

            return $query->selectRaw(
                "*, 
                ({$earthRadius} * acos(
                    cos(radians(?))
                    * cos(radians(lat))
                    * cos(radians(lng) - radians(?))
                    + sin(radians(?))
                    * sin(radians(lat))
                )) AS distance",
                [$lat, $lng, $lat]
            )->having('distance', '<=', $radiusKm);
        }
        return $query;
    }
}