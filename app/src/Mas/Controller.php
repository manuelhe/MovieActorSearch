<?php
namespace Mas;

/**
 * Abstract Controller Class
 *
 * @author manuel.he@gmail.com
 */
abstract class Controller {
    protected $config;
    protected $urlParams;
    public function __construct(\ArrayAccess $config, $urlParams = '') {
        $this->config = $config;
        $this->urlParams = parse_url(implode('/',$urlParams));
    }
    abstract public function response();
}
