<?php

interface Combatente {
    public function atacar(Personagem $alvo);
    public function defender();
    public function habilidadeEspecial1(Personagem $alvo);
    public function habilidadeEspecial2(Personagem $alvo);
}