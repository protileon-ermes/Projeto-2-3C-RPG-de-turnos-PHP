<?php

class Guerreiro extends Personagem implements Combatente {
    public function __construct($nome) {
        // vida ataque defesa energia
        parent::__construct($nome, 120, 15, 12, 50);
    }

    public function getNomeEspecial1(): string { return "Golpe de Escudo"; }
    public function getNomeEspecial2(): string { return "Grito de Guerra"; }

    public function habilidadeEspecial1(Personagem $alvo) {
        $this->verificarEnergia(25);
        $dano = $this->ataque + ($this->defesa * 0.8);
        $alvo->receberDano($dano);
        $this->setEnergia($this->getEnergia() - 25);
        return "{$this->nome} usou {$this->getNomeEspecial1()} causando {$dano} de dano!";
    }

    public function habilidadeEspecial2(Personagem $alvo) {
        $this->verificarEnergia(40);
        $this->ataque += 8;
        $this->setEnergia($this->getEnergia() - 40);
        return "{$this->nome} usou {$this->getNomeEspecial2()}! Seu ataque subiu permanentemente.";
    }
}