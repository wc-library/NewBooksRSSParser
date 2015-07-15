<?php
define('CLASSES_DIR', 'classes/');

// Automatically load undefined classes from |CLASSES_DIR|.
function __autoload( $className ) {
	if (file_exists(CLASSES_DIR) && is_readable(CLASSES_DIR) && is_dir(CLASSES_DIR)) {
        $filename = CLASSES_DIR . $className . '.php';
        if (file_exists($filename) && is_readable($filename) && is_file($filename)) {
            require($filename);
        }
	}
}

$feed = new CarliBookFeed();
$call_numbers = array();
foreach($feed->items() as $item) {
    $call_numbers[] = strtoupper($item->call_number) . strtr("\n$item->classification_type\n$item->subject",'_',' ');
}

if(asort($call_numbers))
    foreach($call_numbers as $cn)
        echo "$cn\n\n";
