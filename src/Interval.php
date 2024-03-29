<?php
namespace Vendimia\DateTime;

use InvalidArgumentException;

/**
 * Time interval
 */
class Interval extends Elements
{
    /**
     * Builds an interval from the time elements
     */
    public function __construct(array $elements = [])
    {
        if ($elements) {
            // No usamos setPart(), para evitar reconstruir el timestamp cada
            // vez que cambiemos una parte.
            foreach ($elements as $name => $value) {
                if (!key_exists($name, $this->element)) {
                    throw new InvalidArgumentException("'$name' is not a valid DateTime element.");
                }

                $this->element[$name] = $value;
            }

            if (isset($elements['timestamp']) && $elements['timestamp']) {
                $this->timestamp = $elements['timestamp'];
            }
        }
    }

    /**
     * Returns an Interval built from DateTime::diff().
     *
     * Useful for processing Timestamp arithmetics
     */
     public static function fromDiff($seconds, $months)
     {
         $elements = [
             'second' => $seconds % 60,
             'minute' => floor($seconds / 60) % 60,
             'hour' => floor($seconds / 3600) % 24,
             'day' => floor($seconds / 86400),
             'month' => $months % 12,
             'year' => floor($months / 12),
             'timestamp' => $seconds,
             'months' => $months,
         ];
         return new static($elements);
     }

    /**
     * Returns the Timestamp-like value for this Interval
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Returns the interval seconds in average gregorian years
     */
    public function asYears()
    {
        return $this->timestamp / 31556952;
    }

    /**
     * Returns the $months part of the interval
     */
    public function getMonthInterval()
    {
        return $this->element['months'];
    }

    /**
     * Creates a Year interval
     */
    public static function year($year)
    {
        return new static(['year' => $year]);
    }

    /**
     * Alias of static::year()
     */
    public static function years($year)
    {
        return static::year($year);
    }

    /**
     * Creates a Month interval
     */
    public static function month($month)
    {
        return new static(['month' => $month]);
    }

    /**
     * Alias of static::month()
     */
    public static function months($month)
    {
        return static::month($month);
    }

    /**
     * Creates a Day interval
     */
    public static function day($day)
    {
        return new static(['day' => $day]);
    }

    /**
     * Alias of static::day()
     */
    public static function days($day)
    {
        return static::day($day);
    }

    /**
     * Creates an Hour interval
     */
    public static function hour($hour)
    {
        return new static(['hour' => $hour]);
    }

    /**
     * Alias of static::hour()
     */
    public static function hours($hour)
    {
        return static::hour($hour);
    }

    /**
     * Creates a Minute interval
     */
    public static function minute($minute)
    {
        return new static(['minute' => $minute]);
    }

    /**
     * Alias of static::minute()
     */
    public static function minutes($minute)
    {
        return static::minute($minute);
    }

    /**
     * Creates an Second interval
     */
    public static function second($second)
    {
        return new static(['second' => $second]);
    }

    /**
     * Alias of static::second()
     */
    public static function seconds($second)
    {
        return static::second($second);
    }

}
