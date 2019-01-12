<?php

namespace Wruczek\TSWebsite\Utils;

use Wruczek\TSWebsite\Utils\Language\LanguageUtils;

class DateUtils {

    /**
     * Returns current date format based on current user language. If it cannot
     * be retrieved, default value is returned
     * @return string date format
     */
    public static function getDateFormat() {
        try {
            return LanguageUtils::i()->translate("DATE_FORMAT");
        } catch (\Exception $e) {
            return "d.m.Y";
        }
    }

    /**
     * Returns current time format based on current user language. If it cannot
     * be retrieved, default value is returned
     * @return string time format
     */
    public static function getTimeFormat() {
        try {
            return LanguageUtils::i()->translate("TIME_FORMAT");
        } catch (\Exception $e) {
            return "H:i:s";
        }
    }

    /**
     * Returns timestamp formatted to string with format from getDateFormat()
     * @param $timestamp
     * @return false|string
     */
    public static function formatDate($timestamp) {
        return date(self::getDateFormat(), $timestamp);
    }

    /**
     * Returns timestamp formatted to string with format from getTimeFormat()
     * @param $timestamp
     * @return false|string
     */
    public static function foramtTime($timestamp) {
        return date(self::getTimeFormat(), $timestamp);
    }

    /**
     * Returns timestamp formatted with formatToDate() and formatToTime()
     * @param $timestamp
     * @param string $additional additional date format
     * @return false|string
     */
    public static function formatDatetime($timestamp, $additional = "") {
        return date(trim(self::getDateFormat() . ", " . self::getTimeFormat() . " " . $additional), $timestamp);
    }

}
