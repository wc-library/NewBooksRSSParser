<?php

$CLASSES_DIR = 'classes/';

// Autoloader
function __autoload( $className ) {
    $parts = explode('\\', $className);
    require "classes/".end($parts).".php";
}

$feed = new CarliBookFeed();
echo $feed->xml();