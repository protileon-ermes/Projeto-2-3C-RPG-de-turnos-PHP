<?php

spl_autoload_register(function ($classe) {
    $diretorios = [
        __DIR__ . '/classes/',
        __DIR__ . '/excecoes/',
        __DIR__ . '/interfaces/',
        __DIR__ . '/personagens/'
    ];

    foreach ($diretorios as $diretorio) {
        $arquivo = $diretorio . $classe . '.php';
        if (file_exists($arquivo)) {
            require_once $arquivo;
            return;
        }
    }
});