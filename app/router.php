<?php 

class Router {
    private $routes;
    private $pathNotFound;
    private $methodNotAllowed;
    
    public function __construct() {
        $this->routes = Array();
        $this->pathNotFound = null;
        $this->methodNotAllowed = null;
    }

    public function add($expression, $function, $method = 'get') {
        array_push($this->routes,Array(
            'expression' => $expression,
            'function' => $function,
            'method' => $method
        ));
    }

    public function pathNotFound($function) {
        $this->pathNotFound = $function;
    }

    public function methodNotAllowed($function) {
        $this->methodNotAllowed = $function;
    }

    public function run($basepath = '/') {

        // Parse current url
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri

        if(isset($parsed_url['path'])){
            $path = $parsed_url['path'];
        }else{
            $path = '/';
        }

        // Get current request method
        $method = $_SERVER['REQUEST_METHOD'];

        $path_match_found = false;

        $route_match_found = false;

        foreach($this->routes as $route){

            // If the method matches check the path

            // Add basepath to matching string
            if($basepath!=''&&$basepath!='/'){
            $route['expression'] = '('.$basepath.')'.$route['expression'];
            }

            // Add 'find string start' automatically
            $route['expression'] = '^'.$route['expression'];

            // Add 'find string end' automatically
            $route['expression'] = $route['expression'].'$';

            // echo $route['expression'].'<br/>';

            // Check path match	
            if(preg_match('#'.$route['expression'].'#',$path,$matches)){

            $path_match_found = true;

            // Check method match
            if(strtolower($method) == strtolower($route['method'])){

                array_shift($matches);// Always remove first element. This contains the whole string

                if($basepath!=''&&$basepath!='/'){
                array_shift($matches);// Remove basepath
                }

                call_user_func_array($route['function'], $matches);

                $route_match_found = true;

                // Do not check other routes
                break;
            }
            }
        }

        // No matching route was found
        if(!$route_match_found) {

            // But a matching path exists
            if($path_match_found){
            header("HTTP/1.0 405 Method Not Allowed");
            if($this->methodNotAllowed){
                call_user_func_array($this->methodNotAllowed, Array($path,$method));
            }
            }else{
            header("HTTP/1.0 404 Not Found");
            if($this->pathNotFound){
                call_user_func_array($this->pathNotFound, Array($path));
            }
            }

        }

    }

}
