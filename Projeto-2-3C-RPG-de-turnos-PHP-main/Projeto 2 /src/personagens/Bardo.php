<?php

class Bardo extends Personagem implements Combatente {
    public function __construct($nome) {
        parent::__construct($nome, 85, 18, 8, 90);
    }

    public function getNomeEspecial1(): string { return "Solo de Guitarra"; }
    public function getNomeEspecial2(): string { return "lofi beats to relax/study"; }

    public function habilidadeEspecial1(Personagem $alvo): string {
        $this->verificarEnergia(30);
        $alvo->adicionarEfeito("Tocando", 3, 15);
        $this->setEnergia($this->getEnergia() - 30);
        return "{$this->nome} usou {$this->getNomeEspecial1()}! {$alvo->getNome()} está inspirado e causará mais dano por 3 turnos!";
    }

    public function habilidadeEspecial2(Personagem $alvo): string {
        $this->verificarEnergia(25);
        $dano = 20;
        $alvo->receberDano($dano);
        $cura = 30;
        $this->setVida($this->getVida() + $cura);
        $this->setEnergia($this->getEnergia() - 25);
        return "{$this->nome} usou {$this->getNomeEspecial2()}! Curou {$cura} de vida de {$this->getNome()} e abalou {$alvo->getNome()}, sendo um cara tranquilo!";
    }
}