<?php

namespace Wruczek\TSWebsite\Utils;


trait SingletonTait {

    /**
     * Call this method to get singleton
     * @return self
     */
    public static function Instance() {
        static $inst = null;

        if ($inst === null)
            $inst = new self();

        return $inst;
    }

    /**
     * A shorthand to get the singleton
     * @return self
     */
    public static function i() {
        return self::Instance();
    }

}
