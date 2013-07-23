<?php
/**
 * @package library_TF_cache
 */

/**
 * The cache frontend class.
 * 
 * @package library_TF_cache
 */
class TF_Cache_Core extends Zend_Cache_Core {

    /**
     * Increments the version of cached item.
     * 
     * @param string $key 
     * @param int $value 
     * @return int|bool 
     */
    public function increment($id, $value = 1) {
        return $this->_backend->increment($id, $value);
    }

    /**
     * Returns the value by key.
     *
     * @param string $key
     * @return mixed
     */
    public function getCached($key) {
        return $this->_backend->getCached($key);
    }
    
    /**
    * Caches the value by key.
    *
    * @param string $key
    * @param mixed $value
    * @return void
    */
    public function cache($key, $value = null) {
        return $this->_backend->cache($key, $value);
    }

    /**
     * Generates a unique key taking into account version of item to be cached.
     * 
     * @param string $className
     * @param string $methodName
     * @param array $args
     * @param array $versionKeys
     * @return string
     */
    public function generateCacheKey($className, $methodName, $args, $versionKeys = array()) {
        $cache = &$this->cache;
        $cacheKey = $className . $methodName . serialize($args);
        $cacheKey = $this->addVersionToKey($cacheKey, $versionKeys);
        $cacheKey = hash('sha256', $cacheKey);
        return $cacheKey;
    }

    /**
     * Adds version to the cache key.
     * 
     * @param string $cacheKey
     * @param array $versionKeys
     * @return string
     */
    private function addVersionToKey($cacheKey, $versionKeys){
        $cache = $this->_backend;
        foreach ($versionKeys as $entityName) {
            $entityVersion = $cache->getCached($entityName);
            if ($entityVersion === null || (int)($entityVersion) != $entityVersion) {
                $cache->cache($entityName, 1);
                $entityVersion = 1;
            }
            $cacheKey .= '_' . $entityName . '_v' . $entityVersion;
        }
        return $cacheKey;
    }
}
?>