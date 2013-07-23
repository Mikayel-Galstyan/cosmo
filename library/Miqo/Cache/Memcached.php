<?php
/**
 * @package library_TF_cache
 */

/**
 * The class which provides storing of records in the memcached server.
 *
 * @package library_TF_cache
 */
class TF_Cache_Memcached extends Zend_Cache_Backend_Memcached {
        
    /**
     * Increments the version of cached item.
     * 
     * @param string $key 
     * @param int $value 
     * @return int|bool 
     */
    public function increment($key, $value = 1) {
        $memc        = $this->_memcache;
        $value       = (int) $value;
        $memc->add($key, 0);
        $newValue    = $memc->increment($key, $value);
        return $newValue;
    }
    
    /**
     * Returns the value by key.
     * 
     * @param string $key
     * @return mixed
     */
    public function getCached($key) {
        $result = $this->load($key);
        return ($result === false) ? null : $result;
    }

    /**
     * Caches the value by key.
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function cache($key, $value = null) {
        // if no value is specified, remove the cached entry
        if(is_null($value)) {
            $this->remove($key);
        }

        $this->save($value, $key);
    }    
    
    /** 
     * Returns unserialized value of the cached record by key.
     * 
     * @param string key
     * @param boolean $doNotTestCacheValidity
     * @return mixed
     */
    public function load($id, $doNotTestCacheValidity = false){
        //"tags" are not supported for the moment as the "doNotTestCacheValidity=true" argument
    	$tmp = $this->_memcache->get($id);
        return $tmp;
    }
    
    public function save($data, $id, $tags = array(), $specificLifetime = false) {
        $lifetime = $this->getLifetime($specificLifetime);
        if ($this->_options['compression']) {
            $flag = MEMCACHE_COMPRESSED;
        } else {
            $flag = 0;
        }

        // ZF-8856: using set because add needs a second request if item already exists
        $result = @$this->_memcache->set($id, $data, $flag, $lifetime);

        if (count($tags) > 0) {
            $this->_log(self::TAGS_UNSUPPORTED_BY_SAVE_OF_MEMCACHED_BACKEND);
        }

        return $result;
    }
}
?>
