<?php

class FuncaoJogo {
private array $historico = [];
    private const VERDE     = "\033[0;32m";
    private const AMARELO   = "\033[1;33m";
    private const VERMELHO  = "\033[0;31m";
    private const AZUL      = "\033[0;34m";
    private const RESET     = "\033[0m";

    public function renderizarBarra(float $atual, float $maxima, string $corBase): string {
        $larguraBarra = 20;
        $proporcao = ($maxima > 0) ? ($atual / $maxima) : 0;
        $preenchido = (int)round($proporcao * $larguraBarra);
        $preenchido = max(0, min($larguraBarra, $preenchido));

        $barra = str_repeat("#", $preenchido);
        $vazio = str_repeat("-", $larguraBarra - $preenchido);

        return $corBase . "[$barra$vazio]" . self::RESET;
    }

    public function exibirPainelGrupos(array $t1, array $t2, int $turno): void {
        echo "\n" . str_repeat("=", 65) . "\n";
        echo " ⚔️  ARENA PHP - TURNO " . sprintf("%02d", $turno) . "  ⚔️\n";
        echo str_repeat("-", 65) . "\n";

        echo " TIME 1:\n";
        foreach ($t1 as $p) {
            $this->imprimirLinhaPersonagem($p);
        }

        echo "\n TIME 2:\n";
        foreach ($t2 as $p) {
            $this->imprimirLinhaPersonagem($p);
        }
        echo str_repeat("=", 65) . "\n";
    }

    private function imprimirLinhaPersonagem(Personagem $p): void {
        if ($p->getVida() <= 0) {
            echo sprintf(" %-12s [   MORTO   ]\n", $p->getNome());
            return;
        }

        $porcentagemVida = $p->getVida() / $p->getVidaMaxima();
        $corVida = self::VERDE;
        if ($porcentagemVida < 0.3) $corVida = self::VERMELHO;
        elseif ($porcentagemVida < 0.6) $corVida = self::AMARELO;

        $barraVida = $this->renderizarBarra($p->getVida(), $p->getVidaMaxima(), $corVida);
        $barraMana = $this->renderizarBarra($p->getEnergia(), $p->getEnergiaMaxima(), self::AZUL);

        echo sprintf(" %-12s HP: %-30s %.1f\n", $p->getNome(), $barraVida, $p->getVida());
        echo sprintf(" %-12s MP: %-30s %.1f\n", "", $barraMana, $p->getEnergia());
    }

    public function adicionarLog(int $turno, string $mensagem): void {
        $this->historico[$turno][] = $mensagem;
        echo "\033[1;37m>> $mensagem\033[0m\n";
    }

    public function imprimirResumoFinal(): void {
        echo "\n\n" . str_repeat("*", 20) . " HISTÓRICO DA BATALHA " . str_repeat("*", 20) . "\n";
        foreach ($this->historico as $turno => $eventos) {
            echo "\n[TURNO $turno]\n";
            foreach ($eventos as $e) echo "  • $e\n";
        }
    }
}