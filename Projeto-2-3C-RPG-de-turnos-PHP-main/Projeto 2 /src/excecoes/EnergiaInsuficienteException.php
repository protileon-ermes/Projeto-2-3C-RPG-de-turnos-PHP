<?php

class EnergiaInsuficienteException extends Exception {
    public function __construct($mensagem = "Energia insuficiente para esta ação!", $code = 0, Throwable $previous = null) {
        parent::__construct($mensagem, $code, $previous);
    }
}