<?php
$servidor="localhost";
$usuario="filmoteca";
$password="filmoteca";
$bbdd="filmoteca_generos";
//consulta
$sql="SELECT countries.name AS pais, COUNT(countries.name) AS peliculas FROM countries INNER JOIN pellicules ON pellicules.id_pais=countries.id GROUP BY name ORDER BY peliculas DESC LIMIT 10";
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
        $imprimir.='{"País"'.':'.'"'.$fila["pais"].'","Películas":'.$fila['peliculas'].'}';
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