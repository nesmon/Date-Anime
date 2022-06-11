<?php

namespace DateAnime\Router;

class Route
{
    private $matches;
    /**
     * @var string
     */
    private $path;
    private $callable;
    
    /**
     * @param $path
     * @param $callable
     */
    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }
    
    /**
     * @param $url
     * @return bool
     */
    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        
        if(!preg_match($regex, $url, $matches)) {
            return false;
        }
        
        array_shift($matches);
        $this->matches = $matches;
        
        return true;
    }
    
    /**
     * @return mixed
     */
    public function call()
    {
        if(is_string($this->callable)) {
            $params = explode('#', $this->callable);
            $controller = "\\DateAnime\\Controller\\" . $params[0] . "Controller";
            $controller = new $controller();
            $action = $params[1];
            return call_user_func_array([$controller, $action], $this->matches);
        }
        
        return call_user_func_array($this->callable, $this->matches);
    }
}
