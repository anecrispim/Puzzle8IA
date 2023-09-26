<?php
include 'Classes/PuzzleBuscaHorizontal.class.php';

function estadoEsperado($oEstado) {
    $aEstadoEsperado = [[1, 2, 3], [4, 5, 6], [7, 8, 0]];
    return $oEstado->igual(new PuzzleBuscaHorizontal($aEstadoEsperado));
}

function larguraPrimeiraBusca($oEstadoInicial) {
    $oFila = new SplQueue();
    $oVisitado = new SplObjectStorage();
    $oTempoInicial = microtime(true);

    $oFila->enqueue($oEstadoInicial);

    while (!$oFila->isEmpty()) {
        $oEstadoAtual = $oFila->dequeue();
        $oVisitado->attach($oEstadoAtual);

        if (estadoEsperado($oEstadoAtual)) {
            return [$oEstadoAtual, microtime(true) - $oTempoInicial];
        }

        foreach (['up', 'down', 'left', 'right'] as $sAcao) {
            $oNovoEstado = $oEstadoAtual->movimento($sAcao);

            if ($oNovoEstado && !$oVisitado->contains($oNovoEstado)) {
                $oNovoEstado->oPai = $oEstadoAtual;
                $oFila->enqueue($oNovoEstado);
            }
        }
    }

    return [null, 0];
}

function caminhoSolucao($oEstadoFinal) {
    $aCaminho = [];
    $oEstadoAtual = $oEstadoFinal;

    while ($oEstadoAtual) {
        if ($oEstadoAtual->sAcao) {
            array_push($aCaminho, $oEstadoAtual->sAcao);
        }
        $oEstadoAtual = $oEstadoAtual->oPai;
    }

    $aCaminho = array_reverse($aCaminho);

    foreach ($aCaminho as $sPasso) {
        echo $sPasso . "<br>";
    }
}

function implementaBuscaHorizontal($aPuzzleInicial) {
    $oEstadoInicial = new PuzzleBuscaHorizontal($aPuzzleInicial);

    list($oEstadoFinal, $iTempoBusca) = larguraPrimeiraBusca($oEstadoInicial);

    if ($oEstadoFinal) {
        echo "Solução encontrada em $iTempoBusca segundos.<br>";
        caminhoSolucao($oEstadoFinal);
    } else {
        echo "Não foi encontrada uma solução.\n";
    }
}
