<?php
class darkredis {
    public $redis;

    function __construct() {
        $this->redis = new Redis();
        $this->redis->connect('private-db-redis-nyc1-60901-do-user-4725034-0.a.db.ondigitalocean.com', 25061);
        $this->redis->auth(REDIS_PASSWORD);
    }

    function __destruct()
    {
        $this->redis->close();
    }

    function index() {

    }

    function redis_exists ($value) {
        return $this->redis->exists($value);
    }

    function redis_get ($value) {
        return $this->redis->get($value);
    }

    function redis_set ($key,$value) {
        $this->redis->set($key,$value);
    }

}
