<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\Traits\ToStringFormat;
use Illuminate\Database\Eloquent\Model;

class AgendaItem extends Model
{
    protected $fillable = ['time', 'location', 'description'];

    public static $rules = [
        'time' => 'required',
        'location' => 'required|in:Eindhoven,Veldhoven',
        'description' => 'required|string',
    ];

    // Define the valid location options as constants
    public const LOCATION_EINDHOVEN = 'Eindhoven';
    public const LOCATION_VELDHOVEN = 'Veldhoven';

    // Define the accessor method to return the location value as an enum-like string
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

    // Define the mutator method to set the location value based on the provided enum-like string
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

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTimeNow()
    {
        $currentTime = Carbon::now('Europe/Amsterdam');

        return $currentTime;

    }

    public function getStatus()
    {
        $time = Carbon::parse($this->time)->setTimezone('Europe/Amsterdam');
        $currentTime = Carbon::now('Europe/Amsterdam');

        if ($currentTime >= $time && $currentTime <= $time->copy()->addMinutes(15)){
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



    public function getRemainingTime()
    {
        $time = Carbon::parse($this->time)->setTimezone('Europe/Amsterdam');
        $currentTime = Carbon::now('Europe/Amsterdam');
        $timeDifference = $currentTime->diff($time);

        if ($currentTime >= $time && $currentTime <= $time->copy()->addMinutes(15)){
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


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
