<?php

require_once 'autoloader.php';

function selecionarPersonagem($numeroJogador) {
    echo "\n--- JOGADOR $numeroJogador, PREPARE-SE ---\n";

    while (true) { 
        echo "\nEscolha sua classe:\n";
        echo "[1] Guerreiro\n[2] Mago\n[3] Ladino\n[4] Paladino\n[5] Necromante\n[6] Bardo\n";

        $escolha = readline("Digite o número da classe: ");

        switch ($escolha) {
            case '1': return new Guerreiro("Guerreiro");
            case '2': return new Mago("Mago");
            case '3': return new Ladino("Ladino");
            case '4': return new Paladino("Paladino");
            case '5': return new Necromante("Necromante");
            case '6': return new Bardo("Bardo");
            default: 
                echo "\nOpção inválida! Escolha um número de 1 a 6.\n";
        }
    }
}


echo "--- BEM-VINDO À ARENA PHP ---\n";
echo "Escolha o modo de jogo:\n[1] Duelo (1x1)\n[2] Batalha de Grupos (2x2)\n";

$time1 = [];
$time2 = [];
while (true) {
    $modo = readline("Opção: ");
    switch ($modo) {
        case "1":
            $time1[] = selecionarPersonagem("Jogador 1");
            $time2[] = selecionarPersonagem("Jogador 2");
            break 2;
        case "2":
            echo "\n--- SELEÇÃO DO TIME 1 ---\n";
            $time1[] = selecionarPersonagem("Jogador 1A");
            $time1[] = selecionarPersonagem("Jogador 1B");

            echo "\n--- SELEÇÃO DO TIME 2 ---\n";
            $time2[] = selecionarPersonagem("Jogador 2A");
            $time2[] = selecionarPersonagem("Jogador 2B");
            break 2;
        default: echo "Opção inválida! Escolha 1 ou 2\n";
    }   
}


$partida = new Partida($time1, $time2);
$partida->iniciar();