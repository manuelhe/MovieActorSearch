<?php
/**
 * Movie Actor Search
 *
 * Alert Logic Test
 *
 * Dependency Injection Libary thanks to Pimple http://pimple.sensiolabs.org/
 *
 * @autor manuel.he@gmail.com
 * @version 1.0
 */
$script_start_time = microtime(true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Bogota');
$show_stats = FALSE;

// Require vendor autoload libraries
require 'app/vendor/autoload.php';
$di = require 'app/config/di.php';

//Init routing class
$routing = new \Mas\Router($di);
//Run application
$routing->run();

// Print usage basic stats
if($show_stats){
    $total_time = microtime(true) - $script_start_time;
    printf('
    <!-- Generated in %01.3f secs -->'
        ,$total_time
    );
}

