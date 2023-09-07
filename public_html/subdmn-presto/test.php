<?php

use Back\Cross\Router;
use Back\Cross\Security;

require __DIR__ . '/../../subdmns/presto/cross/router.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <input type="text" id='input'>
    <br>
    <button id='btn'>Click aquí</button>
</body>
<script>
    const x = document.getElementById('input');
    console.log(x);
    document.getElementById('btn').addEventListener('click', () => console.log(x.value));
</script>
</html>

