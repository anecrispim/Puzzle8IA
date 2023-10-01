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

    while (!$oFila->isEmpty()) {
        $oEstadoAtual = $oFila->dequeue();
        $oVisitado->attach($oEstadoAtual);

        if (estadoEsperado($oEstadoAtual)) {
            return [$oEstadoAtual, microtime(true) - $oTempoInicial, $oVisitado];
        }

        foreach (['up', 'down', 'left', 'right'] as $sAcao) {
            $oNovoEstado = $oEstadoAtual->movimento($sAcao);

            if ($oNovoEstado && !$oVisitado->contains($oNovoEstado)) {
                $oNovoEstado->oPai = $oEstadoAtual;
                $oFila->enqueue($oNovoEstado);
            }
        }
    }

    return [null, 0, 0];
}

function caminhoSolucao($oEstadoFinal) {
    $aCaminhoAcao = [];
    $aCaminhoPuzzle = [];
    $oEstadoAtual = $oEstadoFinal;

    while ($oEstadoAtual) {
        if ($oEstadoAtual->sAcao) {
            array_push($aCaminhoAcao, $oEstadoAtual->sAcao);
            array_push($aCaminhoPuzzle, $oEstadoAtual);
        }
        $oEstadoAtual = $oEstadoAtual->oPai;
    }

    $aCaminhoAcao = array_reverse($aCaminhoAcao);
    $aCaminhoPuzzle = array_reverse($aCaminhoPuzzle);

    foreach ($aCaminhoAcao as $sPasso) {
        echo $sPasso . "<br>";
    }
    caminhoJs($aCaminhoPuzzle);
}

function caminhoJs($aCaminhoPuzzle) {
    printf(
        '<script>
            debugger;
            var caminho = %s;
            for (var x = 0; x < caminho.length; x++) {
                var array = caminho[x].oPuzzle;
                setTimeout(() => {
                    for (var i = 0; i < array.length; i++) { 
                        coluna = array[i];
                        for (var j = 0; j < coluna.length; j++) { 
                            console.log("foi");
                            $(`.coluna-${j}`, `#linha-${i}`).html(coluna[j]);
                        }
                    }
                }, "1000");
            }
        </script>'
        , json_encode($aCaminhoPuzzle)
    );
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
