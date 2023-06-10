<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\Traits\ToStringFormat;
use Illuminate\Database\Eloquent\Model;

class   AgendaItem extends Model
{
    protected $fillable = ['time', 'location', 'description'];

    // Validatie regels voor het vullen van de velden
    public static $rules = [
        'time' => 'required',
        'location' => 'required|in:Eindhoven,Veldhoven',
        'description' => 'required|string',
    ];

    // Definieer de geldige locatie opties als constanten
    public const LOCATION_EINDHOVEN = 'Eindhoven';
    public const LOCATION_VELDHOVEN = 'Veldhoven';

    // Definieer de functie om de locatie terug te geven als een enum achtige string
    public function getLocationAttribute($value)
    {
        switch ($value) {
            case self::LOCATION_EINDHOVEN:
                return 'Eindhoven';
            case self::LOCATION_VELDHOVEN:
                return 'Veldhoven';
            default:
                return null;
        }
    }

    // Definieer de functie om de locatie in te stellen op basis van de opgegeven enum achtige string
    public function setLocationAttribute($value)
    {
        switch ($value) {
            case 'Eindhoven':
                $this->attributes['location'] = self::LOCATION_EINDHOVEN;
                break;
            case 'Veldhoven':
                $this->attributes['location'] = self::LOCATION_VELDHOVEN;
                break;
            default:
                $this->attributes['location'] = null;
                break;
        }
    }

    // Definieer de relatie met het User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Haal de huidige tijd op
    public function getTimeNow()
    {
        $currentTime = Carbon::now('Europe/Amsterdam');

        return $currentTime;
    }

    // Haal de status van het agendapunt op
    // TODO: Hier is mogelijk nog wat te verbeteren wanneer er tijd voor is.
    public function getStatus()
    {
        $time = Carbon::parse($this->time)->setTimezone('Europe/Amsterdam');
        $currentTime = Carbon::now('Europe/Amsterdam');

        if ($currentTime >= $time && $currentTime <= $time->copy()->addMinutes(15)) {
            $status = "Nu";
        } elseif ($currentTime > $time) {
            $status = "Verlopen";
        } else {
            $timeDifference = $currentTime->diff($time);
            $timeDifferenceString = $timeDifference->format('%a dagen, %h uur, %i minuten');

            if ($timeDifference->d > 0 || $timeDifference->h >= 12) {
                $status = "Gepland";
            } elseif ($timeDifference->h > 4) {
                $status = "Binnen 24 uur";
            } elseif ($timeDifference->h > 0 || $timeDifference->i < 300) {
                $status = "Spoedig";
            } else {
                $status = "Verlopen";
            }
        }

        return $status;
    }

    // Haal de resterende tijd van het agendapunt op
    // TODO: Hier is mogelijk nog wat te verbeteren wanneer er tijd voor is.
    public function getRemainingTime()
    {
        $time = Carbon::parse($this->time)->setTimezone('Europe/Amsterdam');
        $currentTime = Carbon::now('Europe/Amsterdam');
        $timeDifference = $currentTime->diff($time);

        if ($currentTime >= $time && $currentTime <= $time->copy()->addMinutes(15)) {
            $status = $timeDifference->i . " minuten geleden";
        } elseif ($currentTime > $time) {
            $status = "Agendapunt is verlopen";
        } else {
            if ($currentTime > $time) {
                $status = "Agendapunt is verlopen";
            } elseif ($timeDifference->d > 0) {
                $status = "Nog " . $timeDifference->d . " dagen";
            } elseif ($timeDifference->h > 0) {
                $status = "Nog " . $timeDifference->h . " uren";
            } elseif ($timeDifference->i > 0) {
                $status = "Over " . $timeDifference->i . " minuten";
            } elseif ($timeDifference->s >= -300 && $timeDifference->s <= 300) {
                $status = "Momenteel bezig";
            } else {
                $status = "Agendapunt is verlopen";
            }
        }

        return $status;
    }

    // Definieer de relatie met het User model voor de aanmaker van het agendapunt
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
