<?php
namespace Mas;
/**
 * The Movie Database API helper
 *
 * @author manuel.he@gmail.com
 */
class Tmdb
{
    /**
     * API configuration settings
     * @var array
     *      api_key: The Movie Database API key
     *      api_url: API base URL
     *      persistent: Do not close cURL connection after exec. You must do it
     *                  calling \Mas\Tmdb\close() method
     */
    protected $config = array(
        'api_key' => '',
        'api_url' => '',
        'persistent' => FALSE,
    );
    /**
     * cURL handle
     *
     * @var resource
     */
    protected $connection;
    /**
     * Class Constructor
     *
     * @param array $config
     * @throws \BadFunctionCallException
     */
    public function __construct(Array $config = array()) {
        if(!function_exists('curl_init')){
            throw new \BadFunctionCallException('Function curl_init doesn\'t exist. You must install PHP cURL extension.');
        }
        $this->setConfig($config);
        $this->init();
    }
    /**
     * Setup object configurations
     *
     * @param array $config
     */
    public function setConfig(Array $config){
        $this->config = array_merge($this->config, $config);
    }
    /**
     * Instantiate cURL handle connection
     *
     */
    protected function init(){
        $this->connection = curl_init();
        curl_setopt_array($this->connection, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER => FALSE,
            CURLOPT_HTTPHEADER, array("Accept: application/json"),
        ));
    }
    /**
     * Execute cURL request
     *
     * @param string $query
     * @return array | stdObj
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function exec($query){
        if(!(is_resource($this->connection) && get_resource_type($this->connection) === 'curl')){
            $this->init();
        }
        $query = ltrim(trim((string) $query),'/');
        if(!$query){
            throw new \InvalidArgumentException('$query argument is required to perform this operation.');
        }
        $query = $this->config['api_url'] . $query. 'api_key=' . $this->config['api_key'];
        curl_setopt($this->connection, CURLOPT_URL, $query);
        if(!$response = curl_exec($this->connection)){
            throw new \RuntimeException(curl_error($this->connection));
        }
        if(!$this->config['persistent']){
            $this->close();
        }
        $response = json_decode($response);
        if($response === NULL){
            throw new \RuntimeException($this->getJsonError());
        }
        return $response;
    }
    /**
     * Close cURL connection
     */
    public function close(){
        curl_close($this->connection);
        $this->connection = FALSE;
    }
    /**
     * Search by actor name
     *
     * @param string $name
     * @return array Search results for an actor name
     * @throws \InvalidArgumentException
     */
    public function apiSearchPerson($name){
        $name = trim((string) $name);
        if(!$name){
            throw new \InvalidArgumentException('$name argument is invalid or empty.');
        }
        return $this->exec('search/person?query=' . urlencode($name) .'&');
    }
    /**
     * Get credits for a given Person ID
     * @param int $id Internal TMDB Person ID
     * @return array List of involved roles of a person by movies
     * @throws \InvalidArgumentException
     */
    public function apiPersonCredits($id){
        $id = preg_replace('/\D+/', '', $id);
        if(!$id){
            throw new \InvalidArgumentException('$id argument is invalid.');
        }
        return $this->exec("person/{$id}/credits?");
    }
    /**
     * Get the general person information for a specific id.
     * @param int $id Internal TMDB Person ID
     * @return array List of involved roles of a person by movies
     * @throws \InvalidArgumentException
     */
    public function apiPerson($id){
        $id = preg_replace('/\D+/', '', $id);
        if(!$id){
            throw new \InvalidArgumentException('$id argument is invalid.');
        }
        return $this->exec("person/{$id}?");
    }
    /**
     * Get last JSON error
     *
     * @return string
     */
    protected function getJsonError(){
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return 'No errors';
            break;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                return 'Unknown error';
            break;
        }
    }
}