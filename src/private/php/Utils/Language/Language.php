<?php
namespace Wruczek\TSWebsite\Utils\Language;

class Language {

    private $languageId;
    private $languageNameEnglish;
    private $languageNameNative;
    private $languageCode;
    private $isDefault;
    private $languageItems;

    /**
     * Language constructor.
     * @param $languageId
     * @param $languageNameEnglish
     * @param $languageNameNative
     * @param $languageCode
     * @param $isDefault
     * @param $languageItems
     */
    public function __construct($languageId, $languageNameEnglish, $languageNameNative, $languageCode, $isDefault, $languageItems) {
        $this->languageId = $languageId;
        $this->languageNameEnglish = $languageNameEnglish;
        $this->languageNameNative = $languageNameNative;
        $this->languageCode = $languageCode;
        $this->isDefault = $isDefault;
        $this->languageItems = $languageItems;
    }

    /**
     * Returns language ID
     * @return int language ID
     */
    public function getLanguageId() {
        return $this->languageId;
    }

    /**
     * Returns language name in English
     * @return string language name in English
     */
    public function getLanguageNameEnglish() {
        return $this->languageNameEnglish;
    }

    /**
     * Returns language name in its native form
     * @return string language name in its native form
     */
    public function getLanguageNameNative() {
        return $this->languageNameNative;
    }

    /**
     * Returns language code
     * @return string language code
     */
    public function getLanguageCode() {
        return $this->languageCode;
    }

    /**
     * Returns true when this language is set as default site language
     * @return boolean true when default, false otherwise
     */
    public function isDefault() {
        return $this->isDefault;
    }

    /**
     * Sets this language as default language of the site
     * @return boolean true on success, false otherwise
     */
    public function setAsDefaultLanguage() {
        return LanguageUtils::i()->setDefaultLanguage($this);
    }

    /**
     * Returns simple array with identifier -> value mapping, created from getLanguageItems()
     * @return array
     */
    public function getSimpleItemsArray() {
        $ret = [];

        foreach ($this->getLanguageItems() as $item) {
            $ret[$item->getIdentifier()] = $item->getValue();
        }

        return $ret;
    }

    /**
     * Returns language item
     * @param $identifier string identifier
     * @return LanguageItem LanguageItem if found, null otherwise
     */
    public function getLanguageItem($identifier) {
        foreach ($this->getLanguageItems() as $item) {
            if(strcasecmp($item->getIdentifier(), $identifier) === 0)
                return $item;
        }
        return null;
    }

    /**
     * Returns language strings
     * @return array array filled with LanguageItem
     */
    public function getLanguageItems() {
        return $this->languageItems;
    }

}
