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
        date_default_timezone_set('UTC');
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
     * Adds or substracts an interval from this DateTime
     *
     * @param Interval $interval Interval to be added or substracted
     * @param int $sign Multiplier for adding or substracting the interval
     */
    public function plus(Interval $interval, int $sign = 1)
    {
        foreach ($this->element as $name => $value) {
            $this->element[$name] += $interval->getElement($name) * $sign;
        }
        $this->buildTimestampFromElements();

        return $this;
    }

    /**
     * Substracts an interval from this DateTime
     * @param Interval $interval Interval to be substracted
     *
     */
     public function minus(Interval $interval)
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
