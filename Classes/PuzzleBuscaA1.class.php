<?php

class PuzzleBuscaA1 {
    private $aPuzzle;
    private $oPai;
    private $sAcao;
    private $iCusto;

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

    public function __toString() {
        $output = '';
        foreach ($this->aPuzzle as $row) {
            $output .= implode(' ', $row) . "\n";
        }
        return $output;
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

function isGoalState($state) {
    $goal = [[1, 2, 3], [4, 5, 6], [7, 8, 0]];
    return $state->igual(new PuzzleState($goal));
}

function h($state) {
    $goal = [[1, 2, 3], [4, 5, 6], [7, 8, 0]];
    $heuristic = 0;

    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($state->aPuzzle[$i][$j] != $goal[$i][$j]) {
                $heuristic++;
            }
        }
    }

    return $heuristic;
}

function aStarSearch($initialState) {
    $openSet = new SplPriorityQueue();
    $closedSet = new SplObjectStorage();
    $start_time = microtime(true);

    $openSet->insert($initialState, 0);

    while (!$openSet->isEmpty()) {
        $currentState = $openSet->extract();
        $closedSet->attach($currentState);

        if (isGoalState($currentState)) {
            return [$currentState, microtime(true) - $start_time];
        }

        foreach (['up', 'down', 'left', 'right'] as $sAcao) {
            $oNovoEstado = $currentState->move($sAcao);

            if ($oNovoEstado && !$closedSet->contains($oNovoEstado)) {
                $oNovoEstado->oPai = $currentState;
                $g = $oNovoEstado->getiCusto();
                $h = h($oNovoEstado);
                $f = $g + $h;
                $openSet->insert($oNovoEstado, $f);
            }
        }
    }

    return [null, 0];
}

function printSolutionPath($finalState) {
    $path = [];
    $currentState = $finalState;

    while ($currentState) {
        if ($currentState->sAcao) {
            array_push($path, $currentState->sAcao);
        }
        $currentState = $currentState->oPai;
    }

    $path = array_reverse($path);

    foreach ($path as $step) {
        echo $step . "\n";
    }
}

$initialPuzzle = [[2, 3, 6], [1, 5, 0], [4, 7, 8]]; // Exemplo de um estado inicial
$initialState = new PuzzleState($initialPuzzle);

list($finalState, $searchTime) = aStarSearch($initialState);

if ($finalState) {
    echo "Solução encontrada em $searchTime segundos.\n";
    printSolutionPath($finalState);
} else {
    echo "Não foi encontrada uma solução.\n";
}

?>
