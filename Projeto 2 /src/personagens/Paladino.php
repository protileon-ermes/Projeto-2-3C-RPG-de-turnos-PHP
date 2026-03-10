<?php

class Paladino extends Personagem implements Combatente {
    public function __construct($nome) {
        // vida ataque defesa energia
        parent::__construct($nome, 110, 18, 10, 60);
    }

    public function getNomeEspecial1(): string { return "Luz Sagrada"; }
    public function getNomeEspecial2(): string { return "Martelo da Justiça"; }

    public function habilidadeEspecial1(Personagem $alvo) {
        $this->verificarEnergia(30);
        $cura = 25;
        $this->setVida($this->getVida() + $cura);
        $this->setEnergia($this->getEnergia() - 30);
        return "{$this->nome} usou {$this->getNomeEspecial1()} e recuperou vida!";
    }

    public function habilidadeEspecial2(Personagem $alvo) {
        $this->verificarEnergia(20);
        $dano = $this->ataque + 5;
        $alvo->receberDano($dano);
        $this->setEnergia($this->getEnergia() - 20 + 10);
        return "{$this->nome} golpeou com o {$this->getNomeEspecial2()}!";
    }
}