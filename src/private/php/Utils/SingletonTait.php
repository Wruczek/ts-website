<?php

namespace Wruczek\TSWebsite\Utils;


trait SingletonTait {

    /**
     * Call this method to get singleton
     * @return self
     */
    public static function Instance(): self {
        static $inst = null;

        if ($inst === null) {
            $inst = new self();
        }

        return $inst;
    }

    /**
     * A shorthand to get the singleton
     * @return self
     */
    public static function i(): self {
        return self::Instance();
    }

}
