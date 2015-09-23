<?php

require_once("classes/util/Utility.php");
spl_autoload_register('\util\Utility::loadClass');

$tester = new \util\Tester(
    "PR6023.E926 S63 O9 1971",
    "Wade Center -- Stacks (See Desk Attendant)",
    'PE,PN,PQ-PT');
$tester->run()->display();