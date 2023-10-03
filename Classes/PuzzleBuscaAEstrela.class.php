<?php

class PuzzleBuscaAEstrela {
    public $aPuzzle;
    public $oPai;
    public $sAcao;
    public $iCusto;

    public function __construct($aPuzzle) {
        $this->aPuzzle = $aPuzzle;
        $this->oPai = null;
        $this->sAcao = null;
        $this->iCusto = 0;
    }

    public function movimentar($sDirecao) {
        list($iLinhaVazia, $iColunaVazia) = $this->encotrarVazio();
        $oNovoEstado = clone $this;

        if ($sDirecao === 'up' && $iLinhaVazia > 0) {
            $oNovoEstado->trocar($iLinhaVazia, $iColunaVazia, $iLinhaVazia - 1, $iColunaVazia);
            $oNovoEstado->sAcao = 'Mover para Cima';
            $oNovoEstado->iCusto++;
            return $oNovoEstado;
        } elseif ($sDirecao === 'down' && $iLinhaVazia < 2) {
            $oNovoEstado->trocar($iLinhaVazia, $iColunaVazia, $iLinhaVazia + 1, $iColunaVazia);
            $oNovoEstado->sAcao = 'Mover para Baizo';
            $oNovoEstado->iCusto++;
            return $oNovoEstado;
        } elseif ($sDirecao === 'left' && $iColunaVazia > 0) {
            $oNovoEstado->trocar($iLinhaVazia, $iColunaVazia, $iLinhaVazia, $iColunaVazia - 1);
            $oNovoEstado->sAcao = 'Mover para a Esquerda';
            $oNovoEstado->iCusto++;
            return $oNovoEstado;
        } elseif ($sDirecao === 'right' && $iColunaVazia < 2) {
            $oNovoEstado->trocar($iLinhaVazia, $iColunaVazia, $iLinhaVazia, $iColunaVazia + 1);
            $oNovoEstado->sAcao = 'Mover para a Direita';
            $oNovoEstado->iCusto++;
            return $oNovoEstado;
        }

        return null;
    }

    public function encotrarVazio() {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->aPuzzle[$i][$j] === 0) {
                    return [$i, $j];
                }
            }
        }
        return null;
    }

    public function trocar($i1, $j1, $i2, $j2) {
        list($this->aPuzzle[$i1][$j1], $this->aPuzzle[$i2][$j2]) = [$this->aPuzzle[$i2][$j2], $this->aPuzzle[$i1][$j1]];
    }

    public function igual($oPuzzleComparado) {
        return $this->aPuzzle == $oPuzzleComparado->aPuzzle;
    }

    public function getCusto() {
        return $this->iCusto;
    }
}

?>
