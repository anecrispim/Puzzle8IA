<?php
include 'Classes/PuzzleBuscaHorizontal.class.php';

function estadoEsperado($oEstado) {
    $aEstadoEsperado = [[1, 2, 3], [4, 5, 6], [7, 8, 0]];
    return $oEstado->igual(new PuzzleBuscaHorizontal($aEstadoEsperado));
}

 function realizaBusca($oEstadoInicial) {
    $oFila = new SplQueue();
    $oVisitado = new SplObjectStorage();
    $oTempoInicial = microtime(true);

    $oFila->enqueue($oEstadoInicial);

    $iLimite = 899999;
    $iCont = 0;
    while (!$oFila->isEmpty()) {
        $oEstadoAtual = $oFila->dequeue();
        $oVisitado->attach($oEstadoAtual);

        if (estadoEsperado($oEstadoAtual) || $iLimite == $iCont) {
            return [$oEstadoAtual, microtime(true) - $oTempoInicial, $oVisitado];
        }

        foreach (['up', 'down', 'left', 'right'] as $sAcao) {
            $oNovoEstado = $oEstadoAtual->movimento($sAcao);

            if ($oNovoEstado && !$oVisitado->contains($oNovoEstado)) {
                $oNovoEstado->oPai = $oEstadoAtual;
                $oFila->enqueue($oNovoEstado);
            }
        }
        $iCont++;
    }

    return [null, 0, 0];
}

function caminhoSolucao($oEstadoFinal) {
    $aCaminhoPuzzle = [];
    $oEstadoAtual = $oEstadoFinal;

    while ($oEstadoAtual) {
        if ($oEstadoAtual->sAcao) {
            array_push($aCaminhoPuzzle, $oEstadoAtual);
        }
        $oEstadoAtual = $oEstadoAtual->oPai;
    }

    $aCaminhoPuzzle = array_reverse($aCaminhoPuzzle);

    foreach ($aCaminhoPuzzle as $oPuzzle) {
        echo $oPuzzle->sAcao . "<br>";
        imprimirMatrizTableCaminho($oPuzzle->oPuzzle);
    }
}

function implementaBuscaHorizontal($aPuzzleInicial) {
    $oEstadoInicial = new PuzzleBuscaHorizontal($aPuzzleInicial);

    list($oEstadoFinal, $iTempoBusca, $oVisitado) = realizaBusca($oEstadoInicial);

    if ($oEstadoFinal) {
        echo "Solução encontrada em $iTempoBusca segundos.<br>";
        echo sprintf("Quantidade de nodos visitados: %s <br>", $oVisitado->count());
        caminhoSolucao($oEstadoFinal);
    } else {
        echo "Não foi encontrada uma solução.\n";
    }
}
