<?php 
include 'funcoes.php';

// Criar a matriz do puzzle

// if (!isset($_POST['matriz'])) {
//     $aMatriz = criarMatriz();
// } else {
//     $aMatriz = json_decode($_POST['matriz']);
//     if ($_POST['tipo-busca'] == 'bc') {
//         $aMatriz = [[2, 3, 6], [1, 5, 0], [4, 7, 8]];l
//     }
// }

$aMatriz = [[2, 3, 6], [1, 5, 0], [4, 7, 8]];
$aMatriz = [[2, 8, 1], [0, 4, 3], [7, 6, 5]];
// $aMatriz = [[5, 6, 7], [4, 0, 8], [3, 2, 1]];
// $aMatriz = [[8, 7, 1], [6, 0, 2], [5, 4, 3]];

$sTipoBusca = '';
if (isset($_POST['tipo-busca'])) {
    $sTipoBusca = $_POST['tipo-busca'];
}
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <div class="container px-4 py-5">
        <div class="text-center" style="display: flex;flex-direction: column;align-items: center;">
            <h2>Puzzle8</h2>
            <table class="table table-bordered table-center" style="width:50%;">
                <?php
                    imprimirMatrizTablePrincipal($aMatriz);
                ?>
            </table>
        </div>
        <form method="post" action="index.php">
            <input type="hidden" name="matriz" value="<?=json_encode($aMatriz)?>">
            <div class="mb-3">
                <label for="tipo-busca" class="form-label"><b>Resolução por:</b></label>
                <select class="form-select" name="tipo-busca">
                    <option value="bc" <?= $sTipoBusca == 'bc' ? 'selected' : '' ?>>Busca Horizontal</option>
                    <option value="ba1" <?= $sTipoBusca == 'ba1' ? 'selected' : '' ?>>Busca A* (somente com f(x) = g(x))</option>
                    <option value="ba2" <?= $sTipoBusca == 'ba2' ? 'selected' : '' ?>>Busca A* (com f(x) = g(x) + h(x))</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Resolver</button>
        </form>
        <?php
            if (!empty($sTipoBusca)) {

                switch ($sTipoBusca) {
                    case 'bc':
                        include 'buscaHorizontal.php';
                        implementaBuscaHorizontal($aMatriz);
                        break;
                    case 'ba1':
                        include 'buscaAEstrela1.php';
                        implementaBuscaAEstrela1($aMatriz);
                        break;
                    case 'ba2':
                        include 'buscaAEstrela2.php';
                        implementaBuscaAEstrela2($aMatriz);
                        break;
                }
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>