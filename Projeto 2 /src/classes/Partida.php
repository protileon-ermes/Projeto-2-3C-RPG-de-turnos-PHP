<?php

class Partida {
    private array $time1;
    private array $time2;
    private int $turno = 1;
    private FuncaoJogo $ui;

    public function __construct(array $time1, array $time2) {
        $this->time1 = $time1;
        $this->time2 = $time2;
        $this->ui = new FuncaoJogo();
    }

    public function iniciar() {
        while ($this->checarTimeVivo($this->time1) && $this->checarTimeVivo($this->time2)) {
            $this->executarTurno();
            $this->turno++;
        }

        $vencedor = $this->checarTimeVivo($this->time1) ? "TIME 1" : "TIME 2";
        echo "\n🏆 FIM DE JOGO! O $vencedor VENCEU!\n";
        
        $this->ui->imprimirResumoFinal();
    }

    private function executarTurno() {
        $combatentes = array_merge(
            array_map(fn($p) => ['obj' => $p, 'time' => 1], $this->time1),
            array_map(fn($p) => ['obj' => $p, 'time' => 2], $this->time2)
        );

        foreach ($combatentes as $unidade) {
            $atacante = $unidade['obj'];
            $timeInimigo = ($unidade['time'] === 1) ? $this->time2 : $this->time1;

            if ($atacante->getVida() <= 0) continue;
            if (!$this->checarTimeVivo($timeInimigo)) break;

            if (method_exists($atacante, 'verificarStatusTurno')) {
                $aviso = $atacante->verificarStatusTurno();
                if ($aviso) {
                    $this->ui->adicionarLog($this->turno, $aviso);
                }
            }

            $this->ui->exibirPainelGrupos($this->time1, $this->time2, $this->turno);

            $resumoEfeitos = $atacante->processarEfeitos();
            if (!empty($resumoEfeitos)) {
                $this->ui->adicionarLog($this->turno, "Efeitos em {$atacante->getNome()}: $resumoEfeitos");
            }

            if ($atacante->getVida() <= 0) {
                $this->ui->adicionarLog($this->turno, "{$atacante->getNome()} sucumbiu aos efeitos negativos!");
                continue;
            }

            $atacante->setEnergia($atacante->getEnergia() + 5);

            $inimigosVivos = array_filter($timeInimigo, fn($p) => $p->getVida() > 0);
            $alvo = $this->selecionarAlvo($atacante, $inimigosVivos);

            echo "\n> VEZ DE: " . strtoupper($atacante->getNome()) . "\n";
            $this->processarAcao($atacante, $alvo);
        }
    }

    private function selecionarAlvo(Personagem $atacante, array $inimigosVivos): Personagem {
        if (count($inimigosVivos) === 1) {
            return reset($inimigosVivos);
        }

        echo "\nSelecione o alvo para " . $atacante->getNome() . ":\n";
        $opcoes = [];
        $i = 1;
        foreach ($inimigosVivos as $inimigo) {
            echo "[$i] " . $inimigo->getNome() . " (HP: " . $inimigo->getVida() . ")\n";
            $opcoes[$i] = $inimigo;
            $i++;
        }

        while (true) {
            $escolha = (int)readline("Alvo: ");
            if (isset($opcoes[$escolha])) return $opcoes[$escolha];
            echo "Alvo inválido!\n";
        }
    }

    private function processarAcao(Personagem $atacante, Personagem $alvo) {
        $sucesso = false;
        $sp1 = $atacante->getNomeEspecial1();
        $sp2 = $atacante->getNomeEspecial2();

        while (!$sucesso) {
            echo "Ações: [1] Atacar | [2] Defender | [3] $sp1 | [4] $sp2: ";
            $op = readline();

            try {
                $resultado = "";
                switch ($op) {
                    case '1': $resultado = $atacante->atacar($alvo); $sucesso = true; break;
                    case '2': $resultado = $atacante->defender(); $sucesso = true; break;
                    case '3': $resultado = $atacante->habilidadeEspecial1($alvo); $sucesso = true; break;
                    case '4': $resultado = $atacante->habilidadeEspecial2($alvo); $sucesso = true; break;
                    default: echo "Opção inválida!\n"; continue 2;
                }
                $this->ui->adicionarLog($this->turno, $resultado);
            } catch (EnergiaInsuficienteException $e) {
                echo "\033[0;31mAVISO: " . $e->getMessage() . "\033[0m\n";
            }
        }
    }

    private function checarTimeVivo(array $time): bool {
        foreach ($time as $p) {
            if ($p->getVida() > 0) return true;
        }
        return false;
    }
}