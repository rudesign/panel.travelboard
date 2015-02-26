<?php

class Router extends \Phalcon\Mvc\Router{

    public function __construct($defaultRoutes=null){
        parent::__construct($defaultRoutes);
    }

    /**
     * Returns url path segments as array
     * @param null $path
     * @return array
     */
    public function getPathSegments($path = null){
        try{
            if(empty($path)) $path = $this->getRewriteUri();

            $path = array_filter(explode('/', $path));
            $path = implode('/', $path);

            $segments = array_filter(explode('/', $path));

            return $segments;
        }catch (\Exception $e){
            return array('');
        }
    }

    /**
     * Returns current uri path without forwarding slash
     * @return string
     */
    public function getCurrentPath(){
        try{
            if(!$path = $this->getRewriteUri()) throw new \Exception;
            $segments = array_filter(explode('/', $path));

            $url= $this->constructUrl($segments);

            return $url;
        }catch (\Exception $e){
            return '';
        }
    }

    /**
     * Constructs url from arguments and returns result as string
     * @param string|array $path
     * @param array $args
     * @param bool $local
     * @return string
     */
    public function constructUrl($path = null, $args = array(), $external = false){

        if(is_array($path)) $path = implode('/', $path);

        if(is_bool($args)) {
            $external = $args;
            $args = array();
        }

        $url = $this->getDI()->get('url')->get($path, $args, $external);

        return $url;
    }
}