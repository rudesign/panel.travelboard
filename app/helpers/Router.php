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
            $path = array_filter(explode('/', $path));
            $path = implode('/', $path);

            return $path;
        }catch (\Exception $e){
            return '';
        }
    }

    /**
     * Constructs url from arguments and returns result as string
     * @param string $path
     * @param array $query
     * @return string
     */
    public function getUrl($path = '/', $query = array()){

        if(is_array($path)) $path = implode('/', $path);

        if($queryStr = http_build_query($query)) $path .= '?'.$queryStr;

        return $path;
    }
}