<?php

require_once("classes/util/Utility.php");
spl_autoload_register('\util\Utility::loadClass');

$feed = new \xml\feed\Carli("test/test-input.xml");
echo $feed->xml();