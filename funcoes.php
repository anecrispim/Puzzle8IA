<?php


// Função para criar uma matriz 3x3 com números únicos e um 0 em uma posição aleatória
function criarMatriz() {
    $aMatriz = [];

    // Inicialize um array com todos os números possíveis
    $iNumerosPossiveis = range(0, 8);

    // Embaralhe o array para garantir aleatoriedade
    shuffle($iNumerosPossiveis);

    // Preencha a matriz com números únicos
    for ($i = 0; $i < 3; $i++) {
        $iLinha = [];
        for ($j = 0; $j < 3; $j++) {
            // Remova um número do array de números possíveis
            $numero = array_shift($iNumerosPossiveis);
            $iLinha[] = $numero;
        }
        $aMatriz[] = $iLinha;
    }

    return $aMatriz;
}

// Função para imprimir a matriz
function imprimirMatrizTable($aMatriz) {
    foreach ($aMatriz as $iLinha) {
        echo '<tr style="line-height: 100px;">';
        foreach ($iLinha as $iValor) {
            echo '<td style="font-size: 21px;font-weight: 400;">' . $iValor . '</td>';
        }
        echo '</tr>';
    }
}

?>