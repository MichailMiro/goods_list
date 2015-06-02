<?php
/*
 * Helper для работы с cache
 */
function cacheConnection()
{
    $memcacheObj = new Memcache;
    $memcacheObj->connect(CACHE_HOST, CACHE_PORT);
    
    return $memcacheObj;
}

function getCacheRecord($name)
{
    $memcacheObj = cacheConnection();
    $goodsCount = @$memcacheObj->get($name);
    
    return $goodsCount;
}

function setCacheRecord($name,$value)
{
    $memcacheObj = cacheConnection();
    $memcacheObj->set($name, $value, false, CACHE_EXPIRE);
}