<?php
namespace Vendimia\DateTime;

use InvalidArgumentException;

/**
 * Common elements of any date or time object
 */
abstract class Elements
{
    protected $element = [
        'year' => 0,
        'month' => 0,
        'day' => 0,

        'hour' => 0,
        'minute' => 0,
        'second' => 0,
        'msec' => 0,

        'yearday' => 0,
        'weekday' => 0,

        'timestamp' => 0,

        /** Months used on intervals */
        'months' => 0,
    ];

    /** Built timestamp from elements */
    protected $timestamp = null;

    /**
     * Construct an object by retrieving the parts from a timestamp
     */
    protected function fromTimestamp(int $timestamp)
    {
        $e = getdate($timestamp);

        $this->element = [
            'year' => $e['year'],
            'month' => $e['mon'],
            'day' => $e['mday'],

            'hour' => $e['hours'],
            'minute' => $e['minutes'],
            'second' => $e['seconds'],
            'msec' => 0,

            'yearday' => $e['wday'],
            'weekday' => $e['yday'],
        ];

        $this->timestamp = $timestamp;
    }

    /**
     * Calculates the timestamp from the elements
     */
    protected function buildTimestampFromElements()
    {
        $this->timestamp = mktime(
            $this->element['hour'],
            $this->element['minute'],
            $this->element['second'],

            $this->element['month'],
            $this->element['day'],
            $this->element['year'],
        );
    }

    /**
     * Sets an element value
     */
    public function setElement($element, $value): self
    {
        if (!key_exists($element, $this->element)) {
            throw new InvalidArgumentException("'{$element}' is not a valid DateTime element.");
        }

        $this->element[$element] = $value;

        return $this;
    }

    /**
     * Gets an element value
     */
    public function getElement($element): int
    {
        return $this->element[$element];
    }


    /**
     * Returns the year element
     */
    public function getYear(): int
    {
        return $this->getElement('year');
    }

    /**
     * Alias de self::getYears()
     */
    public function getYears(): int
    {
        return $this->getYear();
    }

    /**
     * Set the year element
     */
    public function setYear(int $year): self
    {
        return $this->setElement('year', $year);
    }

    /**
     * Returns the month element
     */
    public function getMonth(): int
    {
        return $this->getElement('month');
    }

    /**
     * Alias de self::getMonth()
     */
    public function getMonths(): int
    {
        return $this->getMonth();
    }

    /**
     * Set the month element
     */
    public function setMonth(int $month): self
    {
        return $this->setElement('month', $month);
    }

    /**
     * Returns the day element
     */
    public function getDay(): int
    {
        return $this->getElement('day');
    }

    /**
     * Alias de self::getDay()
     */
    public function getDays(): int
    {
        return $this->getDay();
    }

    /**
     * Set the day element
     */
    public function setDay(int $day): self
    {
        return $this->setElement('day', $day);
    }

    /**
     * Returns the hour element
     */
    public function getHour(): int
    {
        return $this->getElement('hour');
    }

    /**
     * Alias de self::getHour()
     */
    public function getHours(): int
    {
        return $this->getHour();
    }

    /**
     * Set the hour element
     */
    public function setHour(int $hour): self
    {
        return $this->setElement('hour', $hour);
    }

    /**
     * Returns the minute element
     */
    public function getMinute(): int
    {
        return $this->getElement('minute');
    }

    /**
     * Alias de self::getMinute()
     */
    public function getMinutes(): int
    {
        return $this->getMinute();
    }

    /**
     * Set the minute element
     */
    public function setMinute(int $minute): self
    {
        return $this->setElement('minute', $minute);
    }

    /**
     * Returns the second element
     */
    public function getSecond(): int
    {
        return $this->getSecond('second');
    }

    /**
     * Alias de self::getSecond()
     */
    public function getSeconds(): int
    {
        return $this->getSecond();
    }

    /**
     * Set the second element
     */
    public function setSecond(int $second): self
    {
        return $this->setElement('second', $second);
    }
}
