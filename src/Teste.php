<?php

// Interface base
interface BaseClass {
    public function baseMethod();
}

// Classe principal com herança
class TestClass implements BaseClass {
    private $atributo;

    public function baseMethod() {
        return "Base method";
    }

    // Método com parâmetros, operadores aritméticos e lógicos
    public function calcular($a, $b, $c = 10) {
        $this->atributo = $a + $b * $c; // Operadores aritméticos
        $validacao = $this->atributo > 100 && $c < 20; // Operadores lógicos
        if ($validacao) {
            return "Alto";
        } elseif ($this->atributo > 50 || $c > 5) { // Elseif dentro do if
            return "Médio";
        } else {
            return "Baixo";
        }
    }

    // Método usando try-catch e return dentro do catch
    public function dividir($x, $y) {
        try {
            if ($y == 0) {
                throw new Exception("Divisão por zero");
            }
            return $x / $y;
        } catch (Exception $e) {
            return "Erro: " . $e->getMessage();
        }
    }

    // Método que contém um switch
    public function avaliarNota($nota) {
        switch ($nota) {
            case 10:
                return "Excelente";
            case 7:
                return "Bom";
            case 5:
                return "Regular";
            default:
                return "Ruim";
        }
    }
}


// Função que usa um loop e operadores aritméticos
function somarNumeros($limite) {
    $soma = 0;
    for ($i = 1; $i <= $limite; $i++) {
        $soma += $i;
    }
    return $soma;
}

// Função com um foreach
function imprimirLista($itens) {
    foreach ($itens as $item) {
        echo "Item: $item\n";
    }
}

// Função com um while
function contarAte($num) {
    $contador = 0;
    while ($contador < $num) {
        echo "Contando: $contador\n";
        $contador++;
    }
}

// Criando um objeto da classe TestClass
$obj = new TestClass();

// Chamando métodos e funções
echo $obj->calcular(5, 3);
echo "\n";
echo somarNumeros(10);
echo "\n";
echo $obj->dividir(10, 2);
echo "\n";
imprimirLista(["Maçã", "Banana", "Pera"]);
echo "\n";
echo $obj->avaliarNota(7);
echo "\n";
contarAte(3);
