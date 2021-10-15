<?php
namespace Vendimia\DateTime;

use Stringable;

/**
 * Date/Time manipulation
 */
class DateTime extends Elements implements Stringable
{
    public function __construct($source)
    {
        if (is_numeric($source)) {
            $this->timestamp = $source;
        } elseif (is_string($source)) {
            $this->timestamp = strtotime($source);

            // Si no puede interpretar $source, entonces lo convertimos a null
            if ($this->timestamp === false) {
                $this->timestamp = null;
            }
        } elseif ($source instanceof Common || $source instanceof \DateTime) {
            $this->timestamp = $source->getTimestamp();
        }

        if (!is_null($this->timestamp)) {
            $this->fromTimestamp($this->timestamp);
        }
    }

    /**
     * Returns the timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Returns a new DateTime with the $interval added or substracted.
     *
     * @param Interval $interval Interval to be added or substracted
     * @param int $sign Multiplier for adding or substracting the interval
     */
    public function plus(Interval $interval, int $sign = 1): self
    {
        $datetime = clone $this;
        foreach ($datetime->element as $name => $value) {
            $datetime->element[$name] += $interval->getElement($name) * $sign;
        }
        $datetime->buildTimestampFromElements();

        return $datetime;
    }

    /**
     * Substracts an interval from this DateTime
     * @param Interval $interval Interval to be substracted
     *
     */
    public function minus(Interval $interval): self
    {
        return $this->plus($interval, -1);
    }

    /**
     * Returns a formatted date string representation.
     *
     * If a '%' sign is found, then the strftime() PHP function will be used,
     * otherwise the date() function will be used.
     *
     * @param string $format Template for date/time formatting.
     */
    public function format($format = 'Y-m-d H:i:s'): string
    {
        // Si no hay información de la fecha/hora, retornamos una cadena vacía
        if (is_null($this->timestamp)) {
            return '';
        }

        // Si hay un %, usamos strftime()
        if (str_contains($format, '%')) {
            return strftime($format, $this->timestamp);
        }

        // De lo contrario, usamos date()
        return date($format, $this->timestamp);
    }

    /**
     * Returns an interval between two dates, substracting $this from $target.
     *
     * If $target is after $this, interval will be positive, otherwise
     * it will return a negative interval.
     *
     * Due the varying nature of the month's days number, the resulting inteval
     * will have the days and months "disconnected", that is, days can be
     * greater than 31. E.g. two dates with 3 month different will result
     * in a interval with days = 90 and months = 3;
     *
     * @return Interval Interval between the two DateTime;
     */
    public function diff(DateTime $target)
    {
        // Usamos 2 elementos: Primero, los segundos de diferencia
        $seconds = $target->getTimestamp() - $this->getTimestamp();

        // Y los meses de diferencia
        $months = ($target->getYears() * 12 + $target->getMonths()) -
                ($this->getYears() * 12 + $this->getMonths());

        return Interval::fromDiff($seconds, $months);
    }

    /**
     * Returns true when this DateTime instance have no value.
     */
    public function isNull()
    {
        return is_null($this->timestamp);
    }

    /**
     * Syntax sugar for !self::isNull()
     */
    public function notNull()
    {
        return !$this->isNull();
    }

    /**
     * Returns true if $this is before $target
     */
    public function isBefore(DateTime $target)
    {
        return $this->diff($target)->getTimestamp() > 0;
    }

     /**
      * Returns true if $this is before or equals to $target
      */
    public function isBeforeOrEqualsTo(DateTime $target)
    {
        return $this->diff($target)->getTimestamp() >= 0;
    }

     /**
      * Returns true if $this is after $target
      */
     public function isAfter(DateTime $target)
     {
         return $this->diff($target)->getTimestamp() < 0;
     }

    /**
     * Returns true if $this is after or equals to $target
     */
    public function isAfterOrEqualsTo(DateTime $target)
    {
        return $this->diff($target)->getTimestamp() <= 0;
    }

    /**
     * Creates a DateTime object with the actual date and time.
     */
    public static function now()
    {
        return new static(time());
    }

     /**
      * Converts this object to a string
      */
     public function __toString()
     {
         return $this->format();
     }
}
