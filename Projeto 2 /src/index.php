<?php

require_once 'autoloader.php';

function selecionarPersonagem($numeroJogador) {
    echo "\n--- JOGADOR $numeroJogador, PREPARE-SE ---\n";

    echo "Escolha sua classe:\n";
    echo "[1] Guerreiro\n";
    echo "[2] Mago\n";
    echo "[3] Ladino\n";
    echo "[4] Paladino\n";
    echo "[5] Necromante\n";

    $escolha = readline("Digite o número da classe: ");

    switch ($escolha) {
        case '1': return new Guerreiro("Guerreiro");
        case '2': return new Mago("Mago");
        case '3': return new Ladino("Ladino");
        case '4': return new Paladino("Paladino");
        case '5': return new Necromante("Necromante");
        default:
            echo "Escolha inválida! Selecionando Guerreiro por padrão.\n";
            return new Guerreiro($nome);
    }
}

echo "--- BEM-VINDO À ARENA PHP ---\n";
echo "Escolha o modo de jogo:\n[1] Duelo (1x1)\n[2] Batalha de Grupos (2x2)\n";
$modo = readline("Opção: ");

$time1 = [];
$time2 = [];

if ($modo == '2') {
    echo "\n--- SELEÇÃO DO TIME 1 ---\n";
    $time1[] = selecionarPersonagem("Jogador 1A");
    $time1[] = selecionarPersonagem("Jogador 1B");

    echo "\n--- SELEÇÃO DO TIME 2 ---\n";
    $time2[] = selecionarPersonagem("Jogador 2A");
    $time2[] = selecionarPersonagem("Jogador 2B");
} else {
    $time1[] = selecionarPersonagem("Jogador 1");
    $time2[] = selecionarPersonagem("Jogador 2");
}

$partida = new Partida($time1, $time2);
$partida->iniciar();