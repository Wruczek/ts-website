<?php

namespace Wruczek\TSWebsite\Utils;
use Medoo\Medoo;
use Wruczek\TSWebsite\Config;

/**
 * Class DatabaseUtils
 * @package Wruczek\TSWebsite\Utils
 * @author Wruczek 2017
 */
class DatabaseUtils {

    use SingletonTait;

    protected $configUtils;
    protected $db;

    private function __construct() {
        $this->configUtils = Config::i();
    }

    /**
     * Returns database object created with data from
     * database config. Stores connection for reuse.
     * @return \Medoo\Medoo database object
     */
    public function getDb() {
        if($this->db === null) {
            try {
                $db = new Medoo($this->configUtils->getDatabaseConfig());
            } catch (\Exception $e) {
                TemplateUtils::i()->renderErrorTemplate("DB error", "Connection to database failed", $e->getMessage());
                exit;
            }

            $this->db = $db;
        }

        return $this->db;
    }

    /**
     * Returns true if MysqliDb has been ever initialised. Useful
     * for checking if there was a database connection attempt.
     * @return bool
     */
    public function isInitialised() {
        return !empty($this->db);
    }
}
