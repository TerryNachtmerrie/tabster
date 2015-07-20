<?php
namespace Tabster\Library;

class Tools {
    public static function getMysqlDateTimeString(\DateTime $dateTime) {
        $dateTime->setTimeZone(new \DateTimeZone('Europe/Amsterdam'));
        return $dateTime->format('Y-m-d H:i:s');
    }
}
