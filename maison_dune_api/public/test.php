<?php
echo "La URL de tu API es: http://" . $_SERVER['HTTP_HOST'] . str_replace('test.php', '', $_SERVER['REQUEST_URI']) . "api";
