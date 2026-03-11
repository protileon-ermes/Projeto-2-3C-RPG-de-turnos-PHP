<?php

class Ladino extends Personagem implements Combatente {
    
    public function __construct($nome) {
        // vida ataque defesa energia
        parent::__construct($nome, 95, 20, 8, 70);
    }

    public function getNomeEspecial1(): string { 
        return "Adaga Venenosa"; 
    }
    
    public function getNomeEspecial2(): string { 
        return "Lacerar"; 
    }

    public function habilidadeEspecial1(Personagem $alvo) {
        $this->verificarEnergia(30);
        
        $alvo->adicionarEfeito("Veneno", 3, 6);
        
        $this->setEnergia($this->getEnergia() - 30);
        return "{$this->nome} usou {$this->getNomeEspecial1()} e envenenou {$alvo->getNome()}!";
    }

    public function habilidadeEspecial2(Personagem $alvo) {
        $this->verificarEnergia(40);
        
        $dano = $this->ataque;
        $alvo->setVida($alvo->getVida() - $dano);
        
        $this->setEnergia($this->getEnergia() - 45);
        return "{$this->nome} usou {$this->getNomeEspecial2()} causando {$dano} de dano direto!";
    }
}