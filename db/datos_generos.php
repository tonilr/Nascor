<?php
$servidor="localhost";
$usuario="filmoteca";
$password="filmoteca";
$bbdd="filmoteca_generos";
//consulta
$sql="SELECT generos.genero AS genero, COUNT(generos.genero) AS peliculas FROM generos INNER JOIN pellicules ON pellicules.id_genero=generos.id  WHERE not(genero='no definido') GROUP BY genero ORDER BY peliculas DESC LIMIT 10";
//Conexión
$conn = new mysqli($servidor,$usuario,$password,$bbdd);
//Comprobamos la conexión
if ($conn->connect_error){
    return "Fallo en la conexión: $conn->connect_error";
}
//Ejecutamos la consulta
$resultado= $conn->query($sql);
// print_r($resultado);
//Empezamos a imprimir los resultados
if($resultado->num_rows > 0){
    $imprimir="[";
    $n=$resultado->num_rows;
    while ($fila = $resultado->fetch_assoc()){
        $imprimir.='{"Género"'.':'.'"'.$fila["genero"].'","Películas":'.$fila['peliculas'].'}';
        if($n==1){
            $imprimir.="]";
        }else{
            $imprimir.=",";
            $n--;
        }
    }
}
echo $imprimir;

?>