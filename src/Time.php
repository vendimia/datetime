<?php
namespace Vendimia\DateTime;

use Vendimia\Database\ConnectorInterface;


/**
 * Date manupulation class.
 */
class Time extends DateTime
{
    public function __construct($source = null)
    {
        parent::__construct($source);

        if (!is_null($source)) {
            // Eliminamos la fecha
            $this->element['year'] = 0;
            $this->element['month'] = 0;
            $this->element['day'] = 0;

            $this->buildTimestampFromElements();
        }
    }

    public function format($format = 'H:i:s'): string
    {
        return parent::format($format);
    }
}
