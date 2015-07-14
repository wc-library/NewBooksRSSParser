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

$feed = new RSSReader("https://i-share.carli.illinois.edu/newbooks/newbooks.cgi?library=WHEdb&list=all&day=7&op=and&text=&lang=English&submit=RSS");
foreach( $feed->items() as $item) {
    echo $item->asXML() . "<br><br><br>";
}


