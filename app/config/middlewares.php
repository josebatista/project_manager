<?php

$app->addMiddleware('before', function ($c) {
    session_start();
});
$app->addMiddleware('before', function ($c) {
//    header('Content-Type: application/json');
});
/*
$app->addMiddleware('after', function ($c) {
    echo 'after';
});
$app->addMiddleware('after', function ($c) {
    echo 'after2';
});
*/
