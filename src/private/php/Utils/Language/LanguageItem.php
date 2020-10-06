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
    public function __construct(string $identifier, string $value, ?string $comment) {
        $this->identifier = $identifier;
        $this->value = $value;
        $this->comment = $comment;
    }

    /**
     * Returns item identifier
     * @return string
     */
    public function getIdentifier(): string {
        return $this->identifier;
    }

    /**
     * Returns item value
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }

    /**
     * Returns item comment, can be null
     * @return string|null
     */
    public function getComment(): ?string {
        return $this->comment;
    }

    public function __toString(): string {
        return $this->getValue();
    }

}
