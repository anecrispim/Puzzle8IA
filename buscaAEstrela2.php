<?php
include 'Classes/PuzzleBuscaAEstrela.class.php';

function estadoEsperado($oEstado) {
    $aEstadoFinal = [[1, 2, 3], [4, 5, 6], [7, 8, 0]];
    return $oEstado->igual(new PuzzleBuscaAEstrela($aEstadoFinal));
}

function h($oEstado) {
    $aEstadoFinal = [[1, 2, 3], [4, 5, 6], [7, 8, 0]];
    $iDistanciaManhattan = 0;

    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($oEstado->aPuzzle[$i][$j] != 0) {
                $iValor = $oEstado->aPuzzle[$i][$j];
                $aPosicaoEsperada = encontraPosicaoEsperada($iValor, $aEstadoFinal);
                $iDistanciaManhattan += abs($i - $aPosicaoEsperada[0]) + abs($j - $aPosicaoEsperada[1]);
            }
        }
    }

    return $iDistanciaManhattan;
}

function encontraPosicaoEsperada($iValor, $aEstadoFinal) {
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($aEstadoFinal[$i][$j] == $iValor) {
                return [$i, $j];
            }
        }
    }

    return null;
}

function buscaAEstrela($aEstadoInicial) {
    $oAbertos = new SplPriorityQueue();
    $oAbertos->setExtractFlags(SplPriorityQueue::EXTR_DATA);
    $oFechados = new SplObjectStorage();
    $nTempoInicial = microtime(true);

    $oAbertos->insert($aEstadoInicial, 0);

    $iLimite = 110000;
    $iCont = 0;
    while (!$oAbertos->isEmpty()) {
        $oEstadoAtual = $oAbertos->extract();
        $oFechados->attach($oEstadoAtual);

        if (estadoEsperado($oEstadoAtual) || $iLimite == $iCont) {
            return [$oEstadoAtual, (microtime(true) - $nTempoInicial), $oAbertos];
        }

        foreach (['up', 'down', 'left', 'right'] as $action) {
            $oNovoEstado = $oEstadoAtual->movimentar($action);

            if ($oNovoEstado && !$oFechados->contains($oNovoEstado)) {
                $oNovoEstado->oPai = $oEstadoAtual;
                $g = $oNovoEstado->getCusto();
                $h = h($oNovoEstado);
                $f = $g + $h;
                $oAbertos->insert($oNovoEstado, -$f);
            }
        }
        $iCont++;
    }

    return [null, 0, 0];
}

function caminhoSolucao($oEstadoFinal) {
    $aCaminho = [];
    $oEstadoAtual = $oEstadoFinal;

    while ($oEstadoAtual) {
        if ($oEstadoAtual->sAcao) {
            array_push($aCaminho, $oEstadoAtual);
        }
        $oEstadoAtual = $oEstadoAtual->oPai;
    }

    $aCaminho = array_reverse($aCaminho);

    foreach ($aCaminho as $oPasso) {
        echo $oPasso->sAcao . "<br>";
        imprimirMatrizTableCaminho($oPasso->aPuzzle);
    }
}

function implementaBuscaAEstrela2($aPuzzleInicial) {
    $aEstadoInicial = new PuzzleBuscaAEstrela($aPuzzleInicial);

    list($oEstadoFinal, $nTempoBusca, $oAbertos) = buscaAEstrela($aEstadoInicial);

    if ($oEstadoFinal) {
        echo "Solução encontrada em $nTempoBusca segundos.<br>";
        echo sprintf("Quantidade de nodos visitados: %s <br>", $oAbertos->count());
        caminhoSolucao($oEstadoFinal);
    } else {
        echo "Não foi encontrada uma solução.<br>";
    }
}