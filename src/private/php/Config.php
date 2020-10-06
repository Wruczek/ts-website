<?php

namespace Wruczek\TSWebsite;

use Wruczek\PhpFileCache\PhpFileCache;
use Wruczek\TSWebsite\Utils\DatabaseUtils;
use Wruczek\TSWebsite\Utils\TemplateUtils;

/**
 * Class Config
 * @package Wruczek\TSWebsite\Utils
 * @author Wruczek 2017
 */
class Config {

    use Utils\SingletonTait;

    protected $databaseConfig;
    protected $config;

    public static function get(string $key, $default = null) {
        return self::i()->getValue($key, $default);
    }

    private function __construct() {

        if(!defined("__CONFIG_FILE")) {
            die("__CONFIG_FILE is not defined");
        }

        $config = require __CONFIG_FILE;

        if($config === null || !is_array($config)) {
            die("Cannot read the db config file! (" . __CONFIG_FILE . ")");
        }

        $this->databaseConfig = $config;
    }

    /**
     * Returns config used to connect to the database
     * @return array Config as an array
     */
    public function getDatabaseConfig(): array {
        return $this->databaseConfig;
    }

    /**
     * Returns configuration saved in database
     * @return array Config file as an key => value array
     */
    public function getConfig(): array {
        if($this->config === null) {
            try {
                $db = DatabaseUtils::i()->getDb();
                $data = $db->select("config", ["identifier", "type", "value"]);
            } catch (\Exception $e) {
                TemplateUtils::i()->renderErrorTemplate("DB error", "Cannot get config data from database", $e->getMessage());
                exit;
            }

            $cfg = [];

            foreach ($data as $item) {
                $key = $item["identifier"];
                $type = $item["type"];
                $val = $item["value"];

                switch ($type) {
                    case "STRING":
                        $val = (string) $val;
                        break;
                    case "INT":
                        $val = (int) $val;
                        break;
                    case "FLOAT":
                        $val = (float) $val;
                        break;
                    case "BOOL":
                        $val = strtolower($val) === "true";
                        break;
                    case "JSON":
                        $json = json_decode((string) $val, true);

                        if (json_last_error() !== JSON_ERROR_NONE) {
                            throw new \Exception("Error loading config from db: cannot parse JSON from $key");
                        }

                        $val = $json;
                        break;
                    default:
                        throw new \Exception("Error loading config from db: unrecognised data type $type");
                }

                $cfg[$key] = $val;
            }

            $this->config = $cfg;
        }

        return $this->config;
    }

    /**
     * Resets current config cache
     */
    public function clearConfigCache(): void {
        $this->config = null;
    }

    /**
     * Returns value associated with given key
     * @param string $key
     * @param null $default
     * @return mixed value Returns string with
     * the value if key exists, null otherwise
     * @throws \Exception
     */
    public function getValue(string $key, $default = null) {
        return $this->getConfig()[$key] ?? $default;
    }

    /**
     * Saves key => value combo in config table
     * @param string $key
     * @param string|int|float|bool|array|object $value
     * @throws \Exception
     */
    public function setValue(string $key, $value): void {
        $db = DatabaseUtils::i()->getDb();

        switch (gettype($value)) {
            case "string":
                $type = "STRING";
                break;
            case "integer":
                $type = "INT";
                break;
            case "double":
                $type = "FLOAT";
                break;
            case "boolean":
                $type = "BOOL";
                $value = $value ? "true" : "false";
                break;
            case "array":
            case "object":
                $type = "JSON";
                $value = json_encode($value);
                break;
            default:
                throw new \Exception("Unsupported data type");
        }

        $data = [
            "identifier" => $key,
            "type" => $type,
            "value" => $value
        ];

        if($db->has("config", ["identifier" => $key])) {
            $db->update("config", $data, ["identifier" => $key]);
        } else {
            $db->insert("config", $data);
        }

        $this->clearConfigCache();
    }
}
