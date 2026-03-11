<?php

class Mago extends Personagem implements Combatente {
    private int $carga = 0;
    private bool $cargaPronta = false;

    public function __construct($nome) {
        parent::__construct($nome, 80, 25, 5, 100);
    }

    public function getNomeEspecial1(): string { return "Bola de Fogo"; }
    public function getNomeEspecial2(): string { return "Carga Arcana"; }

    public function verificarStatusTurno(): ?string {
        if ($this->carga > 0) {
            $this->carga--;
            if ($this->carga === 0) {
                $this->cargaPronta = true; 
                return "✨ ENERGIA ACUMULADA! A Carga Arcana de {$this->nome} está completa! Próximo ataque terá dano MASSIVO!";
            }
        }
        return null;
    }

    public function atacar(Personagem $alvo): string {
        if ($this->carga > 0) {
            return "{$this->nome} está canalizando energia... (Faltam {$this->carga} turnos)";
        }

        $multiplicador = 1;
        $prefixo = "";

        if ($this->cargaPronta) {
            $multiplicador = 4;
            $this->cargaPronta = false; 
            $prefixo = "IMPACTO ARCANO! ";
        }

        $dano = ($this->ataque * $multiplicador) - $alvo->getDefesa();
        $dano = max(0, $dano);
        $alvo->receberDano($dano);

        return $prefixo . "{$this->nome} atacou {$alvo->getNome()} causando {$dano} de dano!";
    }

    public function habilidadeEspecial1(Personagem $alvo): string {
        $this->verificarEnergia(35);

        if ($this->carga > 0) {
            return "{$this->nome} tentou usar magia, mas a canalização o impediu!";
        }

        $multiplicador = 1;
        if ($this->cargaPronta) {
            $multiplicador = 4;
            $this->cargaPronta = false; 
        }

        $dano = ($this->ataque * 2) * $multiplicador;
        $alvo->receberDano($dano);
        $this->setEnergia($this->getEnergia() - 35);

        if ($multiplicador > 1) {
            return "BOLA DE FOGO! {$this->nome} usou a carga e causou {$dano} de dano!";
        }
        return "{$this->nome} lançou uma {$this->getNomeEspecial1()} causando {$dano} de dano!";
    }

    public function habilidadeEspecial2(Personagem $alvo): string {
        $this->verificarEnergia(60);
        $this->carga = 3;
        $this->cargaPronta = false; 
        $this->setEnergia($this->getEnergia() - 60);
        return "{$this->nome} começou a preparar a {$this->getNomeEspecial2()}!";
    }
}