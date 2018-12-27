<?php
namespace Wruczek\TSWebsite\Utils\Language;

class LanguageItem {

    private $identifier;
    private $value;
    private $comment;

    /**
     * LanguageItem constructor.
     * @param $identifier
     * @param $value
     * @param $comment
     */
    public function __construct($identifier, $value, $comment) {
        $this->identifier = $identifier;
        $this->value = $value;
        $this->comment = $comment;
    }

    /**
     * Returns item identifier
     * @return string
     */
    public function getIdentifier() {
        return $this->identifier;
    }

    /**
     * Returns item value
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Returns item comment, can be null
     * @return string
     */
    public function getComment() {
        return $this->comment;
    }

    public function __toString() {
        return $this->getValue();
    }

}
