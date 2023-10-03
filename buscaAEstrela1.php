<?php
include 'Classes/PuzzleBuscaAEstrela.class.php';

function estadoEsperado($oEstado) {
    $aEstadoFinal = [[1, 2, 3], [4, 5, 6], [7, 8, 0]];
    return $oEstado->igual(new PuzzleBuscaAEstrela($aEstadoFinal));
}

function h($oEstado) {
    $aEstadoFinal = [[1, 2, 3], [4, 5, 6], [7, 8, 0]];
    $iHeuristica = 0;

    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($oEstado->aPuzzle[$i][$j] != $aEstadoFinal[$i][$j]) {
                $iHeuristica++;
            }
        }
    }

    return $iHeuristica;
}

function buscaAEstrela($aEstadoInicial) {
    $oAbertos = new SplPriorityQueue();
    $oAbertos->setExtractFlags(SplPriorityQueue::EXTR_DATA);
    $oFechados = new SplObjectStorage();
    $nTempo = microtime(true);

    $oAbertos->insert($aEstadoInicial, 0);

    $iLimite = 899999;
    $iCont = 0;
    while (!$oAbertos->isEmpty() || $iLimite == $iCont) {
        $oEstadoAtual = $oAbertos->extract();
        $oFechados->attach($oEstadoAtual);

        if (estadoEsperado($oEstadoAtual)) {
            return [$oEstadoAtual, (microtime(true) - $nTempo), $oAbertos];
        }

        foreach (['up', 'down', 'left', 'right'] as $sAcao) {
            $oNovoEstado = $oEstadoAtual->movimentar($sAcao);

            if ($oNovoEstado && !$oFechados->contains($oNovoEstado)) {
                $oNovoEstado->oPai = $oEstadoAtual;
                $g = $oNovoEstado->getCusto();
                $h = h($oNovoEstado);
                $f = $g + $h;
                $oAbertos->insert($oNovoEstado, -$f);
            }
        }
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
        echo $oPasso->sAcao;
        imprimirMatrizTableCaminho($oPasso->aPuzzle);
    }
}

function implementaBuscaAEstrela1($aPuzzleInicial) {
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