<?php

class PuzzleBuscaHorizontal {
    private $oPuzzle;
    public $oPai;
    public $sAcao;

    public function __construct($oPuzzle) {
        $this->oPuzzle = $oPuzzle;
        $this->oPai = null;
        $this->sAcao = null;
    }

    public function movimento($sDirecao) {
        list($iLinhaVazia, $iColunaVazia) = $this->estaVazio();
        $oNovoEstado = clone $this;

        if ($sDirecao === 'up' && $iLinhaVazia > 0) {
            $oNovoEstado->trocar($iLinhaVazia, $iColunaVazia, $iLinhaVazia - 1, $iColunaVazia);
            $oNovoEstado->sAcao = 'Mover para cima';
            return $oNovoEstado;
        } elseif ($sDirecao === 'down' && $iLinhaVazia < 2) {
            $oNovoEstado->trocar($iLinhaVazia, $iColunaVazia, $iLinhaVazia + 1, $iColunaVazia);
            $oNovoEstado->sAcao = 'Mover para Baixo';
            return $oNovoEstado;
        } elseif ($sDirecao === 'left' && $iColunaVazia > 0) {
            $oNovoEstado->trocar($iLinhaVazia, $iColunaVazia, $iLinhaVazia, $iColunaVazia - 1);
            $oNovoEstado->sAcao = 'Mover para a Esquerda';
            return $oNovoEstado;
        } elseif ($sDirecao === 'right' && $iColunaVazia < 2) {
            $oNovoEstado->trocar($iLinhaVazia, $iColunaVazia, $iLinhaVazia, $iColunaVazia + 1);
            $oNovoEstado->sAcao = 'Mover para a Direita';
            return $oNovoEstado;
        }

        return null;
    }

    public function estaVazio() {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->oPuzzle[$i][$j] === 0) {
                    return [$i, $j];
                }
            }
        }
        return null;
    }

    public function __toString() {
        $output = '';
        foreach ($this->oPuzzle as $row) {
            $output .= implode(' ', $row) . "\n";
        }
        return $output;
    }

    public function trocar($i1, $j1, $i2, $j2) {
        list($this->oPuzzle[$i1][$j1], $this->oPuzzle[$i2][$j2]) = [$this->oPuzzle[$i2][$j2], $this->oPuzzle[$i1][$j1]];
    }

    public function igual($oPuzzleComparado) {
        return $this->oPuzzle == $oPuzzleComparado->oPuzzle;
    }

}


?>
