<?php

namespace Wruczek\TSWebsite\Utils;

use Latte\Engine;
use Latte\Runtime\Html;
use Wruczek\TSWebsite\AdminStatus;
use Wruczek\TSWebsite\Config;
use Wruczek\TSWebsite\Utils\Language\LanguageUtils;

/**
 * Class TemplateUtils
 * @package Wruczek\TSWebsite\Utils
 * @author Wruczek 2017
 */
class TemplateUtils {

    use SingletonTait;

    protected $latte;
    private $oldestCache;

    private function __construct() {
        $this->latte = new Engine();
        $this->getLatte()->setTempDirectory(__CACHE_DIR . "/templates");

        // Add custom filters...

        $this->getLatte()->addFilter("fuzzyDateAbbr", function ($s) {
            $default = DateUtils::formatDatetime($s);
            return new Html('<span data-relativetime="fuzzydate" data-timestamp="' . $s . '">' . $default . '</span>');
        });

        $this->getLatte()->addFilter("fullDate", function ($s) {
            $default = DateUtils::formatDatetime($s);
            return new Html('<span data-relativetime="fulldate" data-timestamp="' . $s . '">' . $default . '</span>');
        });

        $this->getLatte()->addFilter("translate", function ($s, ...$args) {
            return new Html(__get($s, $args));
        });
    }

    /**
     * Returns latte object
     * @return \Latte\Engine Latte object
     */
    public function getLatte() {
        return $this->latte;
    }

    /**
     * Echoes rendered template
     * @see renderTemplateToString
     */
    public function renderTemplate($templateName, $data = [], $loadLangs = true) {
        echo $this->renderTemplateToString($templateName, $data, $loadLangs);
    }

    /**
     * Renders and outputs the error template
     * @param string $errorcode Error code
     * @param string $errorname Error title
     * @param string $description Error description
     */
    public function renderErrorTemplate($errorcode = "", $errorname = "", $description = "") {
        $data = ["errorcode" => $errorcode, "errorname" => $errorname, "description" => $description];
        $this->renderTemplate("errorpage", $data, false);
    }

    /**
     * @param $templateName string Name of the template file, without path and extension
     * @param $data array Data passed to the template
     * @param bool $loadLangs true if the languages should be loaded (requires working database connection)
     * @return string Rendered template
     * @throws \Exception when we cannot get the CSRF token
     */
    public function renderTemplateToString($templateName, $data = [], $loadLangs = true) {
        $dbutils = DatabaseUtils::i();

        if($loadLangs) {
            $userlang = LanguageUtils::i()->getLanguageById($_SESSION["userlanguageid"]);

            $data["languageList"] = LanguageUtils::i()->getLanguages();
            $data["userLanguage"] = $userlang;
        }

        if ($timestamp = $this->getOldestCacheTimestamp())
            $data["oldestTimestamp"] = $timestamp;

        $data["tsExceptions"] = TeamSpeakUtils::i()->getExceptionsList();

        if(@$dbutils->isInitialised())
            $data["sqlCount"] = @$dbutils->getDb()->query("SHOW SESSION STATUS LIKE 'Questions'")->fetch()["Value"];
        else
            $data["sqlCount"] = "none";

        $data["config"] = Config::i()->getConfig();

        $csrfToken = CsrfUtils::getToken();
        $data["csrfToken"] = $csrfToken;
        $data["csrfField"] = new Html('<input type="hidden" name="csrf-token" value="' . $csrfToken . '">');

        if (Config::get("adminstatus_enabled")) {
            $data["adminStatus"] = AdminStatus::i()->getStatus(
                Config::get("adminstatus_groups"),
                Config::get("adminstatus_mode"),
                Config::get("adminstatus_hideoffline"),
                Config::get("adminstatus_ignoredusers")
            );
        }

        return $this->getLatte()->renderToString(__TEMPLATES_DIR . "/$templateName.latte", $data);
    }

    /**
     * Returns time elapsed from website load start until now
     * @param bool $raw If true, returns elapsed time in
     * milliseconds. Defaults to false.
     * @return string
     */
    public static function getRenderTime($raw = false) {
        if($raw) {
            return microtime(true) - __RENDER_START;
        } else {
            return number_format(self::getRenderTime(true), 5);
        }
    }

    /**
     * Stores information about the oldest cached page element
     * for later to be displayed in a warning
     * @see getOldestCacheTimestamp
     * @param $data
     */
    public function storeOldestCache($data) {
        if ($data["expired"] && (!$this->oldestCache || $this->oldestCache > $data["time"]))
            $this->oldestCache = $data["time"];
    }

    /**
     * @see storeOldestCache
     * @return int Oldest cache timestamp, null if not set
     */
    public function getOldestCacheTimestamp() {
        return $this->oldestCache;
    }

    /**
     * Outputs either script or link with all parameters needed
     * @param $resourceType string must be either "stylesheet" or "script"
     * @param $url string Relative or absolute path to the resource. {cdnjs} will be
     *        replaced with "https://cdnjs.cloudflare.com/ajax/libs"
     * @param $parameter string|bool|null If boolean, its gonna treat it as a local
     *        resource and add a version timestamp. If string, its gonna treat it as a
     *        integrity hash and add it along with crossorigin="anonymous" tag.
     */
    public static function includeResource($resourceType, $url, $parameter = null) {
        $url = str_replace('{cdnjs}', 'https://cdnjs.cloudflare.com/ajax/libs', $url);
        $attributes = "";

        if (is_bool($parameter)) {
            $filemtime = @filemtime(__BASE_DIR . "/" . $url);

            if ($filemtime !== false) {
                $url .= "?v=$filemtime";
            }
        } else if (is_string($parameter)) {
            // NEEDS to start with a space!
            $attributes = ' integrity="' . Utils::escape($parameter) . '" crossorigin="anonymous"';
        }

        if ($resourceType === "stylesheet") {
            echo '<link rel="stylesheet" href="' . Utils::escape($url) . '"' . $attributes . '>';
        } else if ($resourceType === "script") {
            echo '<script src="' . Utils::escape($url) . '"' . $attributes . '></script>';
        } else {
            throw new \InvalidArgumentException("$resourceType is not a valid resource type");
        }
    }

    /**
     * @see includeResource
     */
    public static function includeStylesheet($url, $parameter = null) {
        self::includeResource("stylesheet", $url, $parameter);
    }

    /**
     * @see includeResource
     */
    public static function includeScript($url, $parameter = null) {
        self::includeResource("script", $url, $parameter);
    }
}
