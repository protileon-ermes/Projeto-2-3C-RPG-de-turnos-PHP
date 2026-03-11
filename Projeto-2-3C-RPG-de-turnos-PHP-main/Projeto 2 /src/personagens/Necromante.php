<?php

class Necromante extends Personagem implements Combatente {
    
    public function __construct($nome) {
        // vida ataque defesa energia
        parent::__construct($nome, 90, 22, 6, 80);
    }

    public function getNomeEspecial1(): string { return "Dreno de Alma"; }
    public function getNomeEspecial2(): string { return "Maldição Sombria"; }

    public function habilidadeEspecial1(Personagem $alvo): string {
        $custo = 35;
        $this->verificarEnergia($custo);

        $danoBase = $this->ataque * 1.5;
        $alvo->receberDano($danoBase);
        
        $cura = $danoBase / 2;
        $this->setVida($this->getVida() + $cura);
        
        $this->setEnergia($this->getEnergia() - $custo);
        
        return "{$this->nome} usou {$this->getNomeEspecial1()}! Sugou {$danoBase} de HP e recuperou {$cura} de vida.";
    }

    public function habilidadeEspecial2(Personagem $alvo): string {
        $custo = 50;
        $this->verificarEnergia($custo);

        $alvo->adicionarEfeito("Agonia", 4, 10);
        
        $this->setEnergia($this->getEnergia() - $custo);
        
        return "{$this->nome} lançou uma {$this->getNomeEspecial2()}! {$alvo->getNome()} sofrerá dano contínuo pelas sombras.";
    }
}