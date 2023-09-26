<?php 
include 'funcoes.php';

// Criar a matriz do puzzle
// if (!isset($_POST['matriz'])) {
//     $aMatriz = criarMatriz();
// } else {
//     $aMatriz = json_decode($_POST['matriz']);
//     if ($_POST['tipo-busca'] == 'bc') {
//         $aMatriz = [[2, 3, 6], [1, 5, 0], [4, 7, 8]]; // Exemplo de um estado inicial
//     }
// }

$aMatriz = [[2, 3, 6], [1, 5, 0], [4, 7, 8]]; // Exemplo de um estado inicial

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="img/puzzleIcon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>Puzzle8</title>
</head>
<body>
    <div class="container px-4 py-5">
        <div class="text-center" style="display: flex;flex-direction: column;align-items: center;">
            <h2>Puzzle8</h2>
            <table class="table table-bordered table-center" style="width:50%;">
                <?php
                    imprimirMatrizTable($aMatriz);
                ?>
            </table>
        </div>
        <form method="post" action="index.php">
            <input type="hidden" name="matriz" value="<?=json_encode($aMatriz)?>">
            <div class="mb-3">
                <label for="tipo-busca" class="form-label"><b>Resolução por:</b></label>
                <select class="form-select" name="tipo-busca">
                    <option value="bc" selected>Busca Horizontal</option>
                    <option value="ba1">Busca A* (somente com f(x) = g(x))</option>
                    <option value="ba2">Busca A* (com f(x) = g(x) + h(x))</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Gerar árvore</button>
        </form>
        <?php
            if (isset($_POST['tipo-busca'])) {
                $sTipoBusca = $_POST['tipo-busca'];

                switch ($sTipoBusca) {
                    case 'bc':
                        include 'buscaHorizontal.php';
                        implementaBuscaHorizontal($aMatriz);
                        break;
                }
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>