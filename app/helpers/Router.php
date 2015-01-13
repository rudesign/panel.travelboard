<?php

class Router extends \Phalcon\Mvc\Router{

    public function __construct($defaultRoutes=null){
        parent::__construct($defaultRoutes);
    }

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

    public function getUrl($path = '/', $query = array()){

        if($queryStr = http_build_query($query)) $path .= '?'.$queryStr;

        return $path;
    }
}