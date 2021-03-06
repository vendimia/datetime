<?php
namespace Vendimia\DateTime;

use Vendimia\Database\ConnectorInterface;

/**
 * Date manupulation class.
 */
class Date extends DateTime
{
    public function __construct($source = null)
    {
        parent::__construct($source);

        if (!is_null($source)) {
            // Eliminamos la hora
            $this->element['hour'] = 0;
            $this->element['minute'] = 0;
            $this->element['second'] = 0;

            $this->buildTimestampFromElements();
        }
    }

    public function format($format = 'Y-m-d'): string
    {
        return parent::format($format);
    }

    /**
     * Returns the year day part
     */
    public function getYearDay()
    {
        return $this->yearday;
    }

    /**
     * Creates a Date object with today
     */
    public static function today()
    {
        return new static(time());
    }

    /**
     * Returns a Date object with tomorrow date
     */
    public static function tomorrow()
    {
        return static::today()->add(Interval::day(1));
    }

    /**
     * Returns a Date object with yesterday date
     */
    public static function yesterday()
    {
        return static::today()->sub(Interval::day(1));
    }

    /**
     * Returns the day of the week as an integer value. 0 == sunday.
     */
    public function getWeekDay()
    {
        return intval(date('w', $this->timestamp));
    }
}
