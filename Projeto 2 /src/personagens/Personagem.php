<?php

abstract class Personagem {
    protected string $nome;
    protected float $vida;
    protected float $vidaMaxima;
    protected float $ataque;
    protected float $defesa;
    protected float $energia;
    protected float $energiaMaxima;
    protected bool $estaDefendendo = false;
    protected array $efeitosAtivos = [];

    const DANO_MINIMO = 0;

    public function __construct(string $nome, float $vida, float $ataque, float $defesa, float $energia) {
        $this->nome = $nome;
        $this->vida = $vida;
        $this->vidaMaxima = $vida;
        $this->ataque = $ataque;
        $this->defesa = $defesa;
        $this->energia = $energia;
        $this->energiaMaxima = $energia;
    }

    public function atacar(Personagem $alvo) {
        $dano = $this->ataque - $alvo->getDefesa();
        
        if ($dano < self::DANO_MINIMO) {
            $dano = self::DANO_MINIMO;
        }

        $alvo->receberDano($dano);
        return "{$this->nome} atacou {$alvo->getNome()} causando {$dano} de dano!";
    }

    public function receberDano(float $dano): void {
        if ($this->estaDefendendo) {
            $dano = $dano / 2;
            $this->estaDefendendo = false;
        }
        
        $this->vida -= max(self::DANO_MINIMO, $dano); 
        if ($this->vida < 0) $this->vida = 0;
    }
    public function defender() {
        $this->estaDefendendo = true;
        return "{$this->nome} assumiu uma postura defensiva!";
    }

    protected function verificarEnergia(float $custo): void {
        if ($this->energia < $custo) {
            throw new EnergiaInsuficienteException("{$this->nome} não tem energia suficiente! (Necessário: $custo)");
        }
    }

    public function getNome(): string { return $this->nome; }
    
    public function getVida(): float { return $this->vida; }
    public function setVida(float $vida): void { 
        $this->vida = max(0, min($vida, $this->vidaMaxima)); 
    }

    public function getAtaque(): float { return $this->ataque; }
    public function setAtaque(float $ataque): void { $this->ataque = $ataque; }

    public function getDefesa(): float { return $this->defesa; }
    
    public function getEnergia(): float { return $this->energia; }
    public function setEnergia(float $energia): void { $this->energia = $energia; }

    abstract public function habilidadeEspecial1(Personagem $alvo);
    abstract public function habilidadeEspecial2(Personagem $alvo);
    abstract public function getNomeEspecial1(): string;
    abstract public function getNomeEspecial2(): string;
    
    public function getVidaMaxima(): float {
    return $this->vidaMaxima;
    }

    public function getEnergiaMaxima(): float {
        return $this->energiaMaxima; 
    }

    public function adicionarEfeito(string $nome, int $duracao, float $danoPorTurno) {
        $this->efeitosAtivos[] = [
            'nome' => $nome,
            'duracao' => $duracao,
            'dano' => $danoPorTurno
        ];
    }

    public function processarEfeitos(): string {
        $resumo = "";
        foreach ($this->efeitosAtivos as $index => &$efeito) {
            $this->vida -= $efeito['dano'];
            $efeito['duracao']--;
            $resumo .= " [{$efeito['nome']}: -{$efeito['dano']} HP]";
            
            if ($efeito['duracao'] <= 0) {
                unset($this->efeitosAtivos[$index]);
            }
        }
        return $resumo;
    }
}