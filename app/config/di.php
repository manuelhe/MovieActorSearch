<?php
/**
 * Dependency Injection Container setup file
 * using PIMP Dependency Injection Libary http://pimple.sensiolabs.org/
 */

//Pimple Instanciation
$di = new Pimple();
//System Values
$global_path = explode('index.php',$_SERVER["PHP_SELF"]);
$baseDir = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
//Config file parsing
$config = parse_ini_file($baseDir.'app/config/config.ini');
$di['config'] = $config + array(
    'baseUrl' => ((
            (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https")
            || (isset($_SERVER['HTTP_REFERER']) && strpos(strtolower($_SERVER['HTTP_REFERER']), 'https') !== FALSE )
            || (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off')
            || (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'],'secure') !== FALSE)
        )
            ? 'https' : 'http').
            '://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'',
    'baseDir' => $baseDir,
    'basePath' => isset($global_path[0]) && $global_path[0] ? $global_path[0] : '',
);
//Database instance
$di['tmdb'] = $di->share(function ($c) {
    return new \Mas\Tmdb(array(
            'api_key' => $c['config']['tmdb']['api_key'],
            'api_url' => $c['config']['tmdb']['api_url'],
            'persistent' => TRUE
    ));
});
return $di;