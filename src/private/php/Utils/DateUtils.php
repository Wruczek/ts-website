<?php

namespace Wruczek\TSWebsite\Utils;

use Wruczek\TSWebsite\Utils\Language\LanguageUtils;

class DateUtils {
    /**
     * Returns current date format based on current user language. If it cannot
     * be retrieved, default value is returned
     * @return string date format
     */
    public function getDateFormat() {
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
    public function getTimeFormat() {
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
    public function formatToDate($timestamp) {
        return date($this->getDateFormat(), $timestamp);
    }

    /**
     * Returns timestamp formatted to string with format from getTimeFormat()
     * @param $timestamp
     * @return false|string
     */
    public function formatToTime($timestamp) {
        return date($this->getTimeFormat(), $timestamp);
    }

    /**
     * Returns timestamp formatted with formatToDate() and formatToTime()
     * @param $timestamp
     * @param string $additional additional date format
     * @return false|string
     */
    public function formatToDateTime($timestamp, $additional = "") {
        return date("{$this->getDateFormat()} {$this->getTimeFormat()} $additional", $timestamp);
    }

    /**
     * Formats timestamp into "time ago" string
     * For example, timestamp set to 60 seconds ago will return "1 minute ago"
     *
     * Taken from StackOverflow: https://stackoverflow.com/a/18602474
     * @param $timestamp int timestamp with past date
     * @param bool $full if true, full date will be returned. For example "5 hours, 2 minutes, 8 seconds"
     * @return string timestamp formatted to fuzzy date. Marf.
     */
    public function fuzzyDate($timestamp, $full = false) {
        $now = new \DateTime;
        $ago = (new \DateTime)->setTimestamp($timestamp);

        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second'
        ];

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    /**
     * Returns fuzzy date with abbreviation showing precise date
     * @see fuzzyDate
     * @param $timestamp
     * @param bool $full
     * @return string
     */
    public function fuzzyDateHTML($timestamp, $full = false) {
        $fuzzyDate = $this->fuzzyDate($timestamp, $full);
        $fullDate = $this->formatToDateTime($timestamp, "T");

        return '<abbr data-fuzzydate="' . $timestamp . '"></abbr>';
//        return '<abbr data-toggle="tooltip" title="' . htmlentities($fullDate) . '">' . htmlentities($fuzzyDate) . '</abbr>';
    }
}
