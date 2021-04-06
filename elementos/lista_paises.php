<?php
function lista_paises($id=0){
    //Datos de la conexión
    $servidor="localhost";
    $usuario="filmoteca";
    $password="filmoteca";
    $bbdd="filmoteca_generos";
    //Consulta para tener los id y los nombres de los géneros
    $sql_paises="SELECT * FROM countries ORDER BY id ASC";
    //Consulta para obtener el id del género de la película
    $sql_pelicula="SELECT `id_pais` FROM `pellicules` WHERE `id`=$id";
    //Conectamos a la base de datos
    $conn = new mysqli ($servidor,$usuario,$password,$bbdd);
    //Extraemos los datos de los generos
    $datos_paises=$conn->query($sql_paises);
    //Extraemos el pais de la película
    $datos_pelicula=$conn->query($sql_pelicula);
    //Guardamos el id del pais de la película
    $id_pais_pelicula=$datos_pelicula->fetch_assoc();
    // print_r ($id_pais);
    if($id!=0){
        $id=$id_pais_pelicula['id_pais'];
    }
    $return= "<label for='pais'>Pais<select name='pais' id='pais'><br>";

    while($fila_paises=$datos_paises->fetch_assoc()){
        if ($fila_paises["id"]==$id){
            $return.= "<option value='$fila_paises[id]' selected>$fila_paises[name]</option>";
        }else{
            $return.= "<option value='$fila_paises[id]'>$fila_paises[name]</option>";
        }
    }
    $return.="</select></label><br>";
    return $return;
}
?>