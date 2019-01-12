<?php

namespace Wruczek\TSWebsite\Utils\Language;

use Wruczek\PhpFileCache\PhpFileCache;
use Wruczek\TSWebsite\Config;
use Wruczek\TSWebsite\Utils\DatabaseUtils;
use Wruczek\TSWebsite\Utils\SingletonTait;

/**
 * Class LanguageUtils
 * @package Wruczek\TSWebsite\Utils
 * @author Wruczek 2017
 */
class LanguageUtils {

    use SingletonTait;

    private $cache;
    private $languages;

    /**
     * Short function for translate
     */
    public static function tl($identifier, $args = []) {
        return self::i()->translate($identifier, $args);
    }

    private function __construct() {
        $this->cache = new PhpFileCache(__CACHE_DIR, "translations");

        $this->languages = $this->cache->refreshIfExpired("languages", function () {
            return $this->refreshLanguageCache(false);
        }, 300);
    }

    /**
     * Returns language by its ID
     * @param $languageId int Language ID
     * @return Language|boolean returns Language when found, false otherwise
     */
    public function getLanguageById($languageId) {
        foreach ($this->getLanguages() as $lang) {
            if($lang->getLanguageId() === $languageId)
                return $lang;
        }

        return false;
    }

    /**
     * Returns language by its Language Code
     * @param $languageCode string Language Code
     * @return Language|boolean returns Language when found, false otherwise
     */
    public function getLanguageByCode($languageCode) {
        foreach ($this->getLanguages() as $lang) {
            if(strcasecmp($lang->getLanguageCode(), $languageCode) === 0)
                return $lang;
        }

        return false;
    }

    /**
     * Returns all available languages
     * @return array|mixed
     */
    public function getLanguages() {
        return $this->languages;
    }

    /**
     * Returns default language
     * @return Language default language
     */
    public function getDefaultLanguage() {
        foreach ($this->getLanguages() as $lang) {
            if($lang->isDefault())
                return $lang;
        }

        return null;
    }

    /**
     * Sets language as default
     * @param $language Language
     * @return boolean true on success, false otherwise
     */
    public function setDefaultLanguage($language) {
        $db = DatabaseUtils::i()->getDb();

        // set all languages as non-default, if this succeeds...
        if($db->update("languages", ["isdefault" => 0])) {
            // ...then set only this language to default
            $success = $db->update("languages", ["isdefault" => 1], ["langid", $language->getLanguageId()]);
            $this->refreshLanguageCache();
            return $success;
        }

        return false;
    }

    /**
     * Tried to determine user language and returns it
     * @return Language user language if determined, null otherwise
     */
    public function detectUserLanguage() {
        if (isset($_COOKIE["tswebsite_language"])) { // check cookie
            $langcode = $_COOKIE["tswebsite_language"];
        } else if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) { // check http headers
            $langcode = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
        }

        // if language with that code exists, return it
        if(!empty($langcode) && ($lang = $this->getLanguageByCode($langcode)))
            return $lang;

        return null;
    }

    /**
     * Refreshes language cache, loads and returns new data
     * @param bool $updateCache true if the file cache should also be updated
     * @return array
     */
    public function refreshLanguageCache($updateCache = true) {
        $db = DatabaseUtils::i()->getDb();
        $data = $db->select("languages", ["langid", "englishname", "nativename", "langcode", "isdefault"]);

        $langs = [];

        foreach ($data as $lang) {
            $langid = $lang["langid"];
            $englishname = $lang["englishname"];
            $nativename = $lang["nativename"];
            $langcode = $lang["langcode"];
            $isdefault = $lang["isdefault"];

            $strings = $db->select("translations", ["identifier", "value", "comment"], ["langid" => $langid]);

            $languageItems = [];

            foreach ($strings as $str)
                $languageItems[] = new LanguageItem($str["identifier"], $str["value"], $str["comment"]);

            $langs[] = new Language($langid, $englishname, $nativename, $langcode, $isdefault, $languageItems);
        }

        uasort($langs, function ($a, $b) {
            if ($a->getLanguageId() === $b->getLanguageId()) {
                return 0;
            }

            return strnatcmp($a->getLanguageNameNative(), $b->getLanguageNameNative());
        });

        $this->languages = $langs;

        if($updateCache)
            $this->cache->store("languages", $langs, Config::get("cache_languages", 300));

        return $langs;
    }

    /**
     * Returns translated text. If identifier is not found in the current
     * language, it tries to get it from the default language.
     * User language is determined with getDefaultLanguage() function.
     * @param $identifier string Translation identifier
     * @param array $args Arguments that will replace placeholders
     * @return string Translated text
     * @throws \Exception When default site or user language cannot
     * be found, and/or if $identifier is not found
     */
    public function translate($identifier, $args = []) {
        if (!is_array($args)) {
            $args = [$args];
        }

        $defaultlang = $this->getDefaultLanguage();
        $lang = $this->getLanguageById(@$_SESSION["userlanguageid"]);

        if(!$lang && !$defaultlang)
            throw new \Exception("Cannot get user or default language");

        $item = $lang->getLanguageItem($identifier);

        if(!$item)
            $item = $defaultlang->getLanguageItem($identifier);

        if(!$item)
            throw new \Exception("Cannot get translation for $identifier");

        $val = $item->getValue();

        // Replace placeholders with values from $args
        foreach ($args as $i => $iValue) {
            // Prevent argument placeholder injection
            $iValue = str_replace(["{", "}"], ["&#123;", "&#125;"], $iValue);

            $val = str_ireplace('{' . $i . '}', $iValue, $val);
        }

        return $val;
    }

}
