<?php
// router.php

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($request_uri === '/activos') {
    include 'activos.php';
} elseif ($request_uri === '/formulario') {
    include 'html/formulario.php';
} elseif ($request_uri === '/reportes') {
    include 'reportes.php';
} else {
    http_response_code(404);
    echo 'Página no encontrada';
}
?>
