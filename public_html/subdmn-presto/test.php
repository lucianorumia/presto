<?php

use Back\Cross\Acts;
use Back\Cross\Security;
use Back\Cross\Views;

require_once __DIR__ . '/../../subdmns/presto/cross/security.php';

$x = new Security;

echo $x->franDecrypt('afgBqurpqqMu4fqfoN7HhA9A==8ef93b02808eb1b835972f19cc443866');
