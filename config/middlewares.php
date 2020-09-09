<?php

$middlewares = [
    'before' => [
        function ($c) {
            session_start();
            echo 'before';
        },
        function ($c) {
            echo 'before2';
        },
    ],
    'after' => [
        function ($c) {
            echo 'after';
        },
        function ($c) {
            echo 'after2';
        },
    ]
];
