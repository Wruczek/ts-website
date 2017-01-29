<?php
require_once __DIR__ . "/../lib/phpfastcache/src/autoload.php";

use phpFastCache\CacheManager;
use phpFastCache\Util\Languages;

class CacheUtils {

    private $cacheInstance;
    private $cacheItem;
    private $key;

    function __construct($key) {

        if(!is_string($key))
            throw new InvalidArgumentException("Key must be a string");

        $this->cacheInstance = CacheManager::getInstance('Files', ["path" => __DIR__ . '/../cache']);
        Languages::setEncoding();
        $this->cacheItem = $this->cacheInstance->getItem($key);
        $this->key = $key;
    }

    public function getCacheInstance() {
        return $this->cacheInstance;
    }

    public function getCacheItem() {
        return $this->cacheItem;
    }

    public function getValue() {
        return $this->cacheItem->get();
    }

    public function setValue($value, $expireTime) {
        $this->cacheItem = $this->cacheItem->set($value)->expiresAfter($expireTime);
        $this->cacheInstance->save($this->cacheItem);
    }

    public function isExpired() {
        return !$this->cacheItem->isHit();
    }

    public function remove() {
        $this->cacheInstance->deleteItem($this->key);
    }

}
