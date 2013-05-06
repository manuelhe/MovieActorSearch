<?php
namespace Mas;
/**
 * Application routing class
 *
 * @author manuel.he@gmail.com
 */
class Router {
    protected $requestUri = 'home';
    protected $config;
    /**
     * Class constructor
     *
     * @param \ArrayAccess $config Pimple Dependence Injection object
     */
    public function __construct(\ArrayAccess $config) {
        $this->requestUri = $this->getRequestUri();
        $this->config = $config;
    }
    /**
     * Run app
     *
     * @return boolean
     */
    public function run(){
        $requestUri = explode('/', $this->requestUri);
        if(!(isset($requestUri[0]) && $requestUri[0])){
            $this->send404();
            return false;
        }
        $controllerClass = '\\Controller\\'.ucfirst(strtolower($requestUri[0]));
        if(!class_exists($controllerClass)){
            $this->send404();
            return false;
        }
        unset($requestUri[0]);
        $controller = new $controllerClass($this->config,  array_values($requestUri));
        return $controller->response();
    }
    /**
     * Send Not Found page
     */
    protected function send404(){
        header('HTTP/1.0 404 Not Found');
        echo "<h1>404 Not Found</h1>";
        echo "The page that you have requested could not be found.";
        exit();
    }
    /**
     * Get requested URI
     *
     * @return string
     */
    protected function getRequestUri() {
        if (!isset($_SERVER['REQUEST_URI']) OR !isset($_SERVER['SCRIPT_NAME'])) {
            return '';
        }
        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
            $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        } elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
            $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }
        if (strncmp($uri, '?/', 2) === 0) {
            $uri = substr($uri, 2);
        }
        $parts = preg_split('#\?#i', $uri, 2);
        $uri = $parts[0];
        if (isset($parts[1])) {
            $_SERVER['QUERY_STRING'] = $parts[1];
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        } else {
            $_SERVER['QUERY_STRING'] = '';
            $_GET = array();
        }
        if ($uri == '/' || empty($uri)) {
            return 'home';
        }
        $uri = parse_url($uri, PHP_URL_PATH);
        // Do some final cleaning of the URI and return it
        return $this->removeInvisibleCharacters(str_replace(array('//', '../'), '/', trim($uri, '/')));
    }
    /**
     * Clear invisible or URL dangerous characters
     *
     * @param string $str
     * @param string $url_encoded
     * @return string
     */
    protected function removeInvisibleCharacters($str, $url_encoded = TRUE) {
        $non_displayables = array();
        // every control character except newline (dec 10)
        // carriage return (dec 13), and horizontal tab (dec 09)
        if ($url_encoded) {
            $non_displayables[] = '/%0[0-8bcef]/'; // url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/'; // url encoded 16-31
        }
        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S'; // 00-08, 11, 12, 14-31, 127
        do {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        } while ($count);
        return $str;
    }
}