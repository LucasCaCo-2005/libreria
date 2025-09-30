<?php

echo "Hola,Mundo <br>";

/*

*/

//Varibles

$variable = "Texto de la variable <br>";
$variable = "Texto de la variable modificado <br>";
echo $variable . "<br>" ;
echo gettype($variable) ;

$variable = 10;
echo $variable . "<br>";

echo gettype($variable) . "<br>";

$sustr =  7;
$sustr =  $sustr - 2;
echo $sustr . "<br>";

const my_const = "Constante de PHP <br>";
echo my_const;

//listas

$lista =  [    "Elemento 1",
    "Elemento 2",
    "Elemento 3"
];

echo $lista[1] . "<br><br>";

array_push($lista, "Elemento 4");

print_r($lista);

//diccionarios

$diccionario = [
    "clave1" => "valor1",
    "clave2" => "valor2",
    "clave3" => "valor3"
];

echo $diccionario["clave2"] . "<br>";

// flujos 

for ($i = 0; $i < 10; $i++) {
    echo "El valor de i es: " . $i . "<br>";
}

echo "<br>";


while ($i < 20) {
    echo "El valor de i es: " . $i . "<br>";
    $i++;
}


foreach ($lista as $elemento) {
    echo "El elemento es: " . $elemento . "<br>";
}

// funciones
function print_number( int $number) {
    echo "El numero es: " . $number . "<br>";
}

print_number(5);

class clase {
public $nombre;
public $edad;

function __construct($nombre, $edad) {
    $this->nombre = $nombre;
    $this->edad = $edad;

}
}

$clase1 = new clase("Juan", 25);
print_r($clase1);

echo $clase1->nombre . "<br>";



$name = 'Linus';
echo '<h1>Hello $name</h1>';
echo "<h1>Hello $name</h1>";

$name = 'Linus';
print '<h1>Hello $name</h1>';
print "<h1>Hello " . $name . "</h1>";

   

?>

