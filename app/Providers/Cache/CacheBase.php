<?php

namespace App\Providers\Cache;

abstract class CacheBase
{
	protected $key;
	protected $expiration;
	protected $tags;
    protected $store;

    function __construct($key, $expiration, $tags = null, $store = null)
    {
    	$this->key = $key;
    	$this->expiration = $expiration;
    	$this->tags = $tags;
        $this->store = $store == null ? config('cache.default') : $store;
    }

    public function getKey()
    {
    	return $this->key;
    }

    public function setData($data)
    {
    	if($this->tags == null){
	    	\Cache::store($this->store)->put($this->key, $data, $this->expiration);
	    }else{
	    	\Cache::store($this->store)->tags($this->tags)->put($this->key, $data, $this->expiration);
	    }
    }

    public function hasData()
    {
    	if($this->tags == null){
    		return \Cache::store($this->store)->has($this->key);
    	}else{
    		return \Cache::store($this->store)->tags($this->tags)->has($this->key);
    	}
    }

    public function getData($default = null)
    {
    	if($this->tags == null){
    		return \Cache::store($this->store)->get($this->key, $default);
    	}else{
    		return \Cache::store($this->store)->tags($this->tags)->get($this->key, $default);
    	}

    }

    public function clear()
    {
    	if($this->tags == null){
    		return \Cache::store($this->store)->forget($this->key);
    	}else{
    		return \Cache::store($this->store)->tags($this->tags)->forget($this->key);
    	}
    }

    public function clearTags()
    {
    	if($this->tags != null){
    		return \Cache::store($this->store)->tags($this->tags)->flush();
    	}
    }
}
