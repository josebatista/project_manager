<?php

$app->addMiddleware('before', function ($c) {
    session_start();
    echo 'before';
});
$app->addMiddleware('before', function ($c) {
    echo 'before2';
});

$app->addMiddleware('after', function ($c) {
    echo 'after';
});
$app->addMiddleware('after', function ($c) {
    echo 'after2';
});
