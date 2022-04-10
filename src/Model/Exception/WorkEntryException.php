<?php

namespace App\Model\Exception;

use Exception;

class WorkEntryException extends Exception
{
    public static function throwException()
    {
        throw new self('WorkEntry no encontrado');
    }

    public static function throwExceptionDate()
    {
        throw new self('endDate es inferior a startDate');
    }
}
