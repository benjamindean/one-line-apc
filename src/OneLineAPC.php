<?php

/**
 * OneLineAPC v0.0.1
 * By Benjamin Dean
 */

class OneLineAPC
{
    /**
     * Default TTL is 22 hours.
     *
     * @var int
     */
    public $ttl = 79200;

    public function __construct($module = 'apc')
    {
        $this->module = $module;
        $this->checkAPC();
    }

    /**
     * @param int $ttl
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
    }

    /**
     * If for some reason you'll suddenly decide to switch from APC to APCu,
     * this may come in handy.
     *
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
        $this->checkAPC();
    }

    /**
     * Checking if extension is loaded.
     *
     * @return bool
     */
    private function checkAPC()
    {
        if (!extension_loaded($this->module)) {
            trigger_error("Extension \"$this->module\" is not loaded", E_USER_NOTICE);
            exit();
        }
    }

    /**
     * Setting cache.
     *
     * @param $key
     * @param $value
     * @param mixed $ttl
     * @return mixed
     */
    public function setCache($key, $value, $ttl = false)
    {
        $function = $this->module . '_store';
        return $function($key, $value, $ttl ?: $this->ttl);
    }

    /**
     * Getting cached value.
     *
     * @param $key
     * @return mixed
     */
    public function getCache($key)
    {
        $function = $this->module . '_fetch';
        return $function($key);
    }

    /**
     * Caching the output of some function.
     * Callback, obviously, should return something.
     *
     * @param $key
     * @param $callback
     * @param $ttl
     * @return mixed
     */
    public function cached($key, $callback, $ttl = false)
    {
        $cachedData = $this->getCache($key);

        if (!$cachedData) {
            $cachedData = call_user_func($callback);
            $this->setCache($key, $cachedData, $ttl);
        }

        return $cachedData;
    }
}