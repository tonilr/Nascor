<?php
function lista_generos($id=0){
    //Datos de la conexión
        $servidor="localhost";
        $usuario="filmoteca";
        $password="filmoteca";
        $bbdd="filmoteca_generos";
    //Consulta para tener los id y los nombres de los géneros
    $sql_generos="SELECT * FROM generos ORDER BY genero ASC";
    //Consulta para obtener el id del género de la película
    $sql_pelicula="SELECT `id_genero` FROM `pellicules` WHERE `id`=$id";
    //Conectamos a la base de datos
    $conn = new mysqli ($servidor,$usuario,$password,$bbdd);
    //Extraemos los datos de los generos
    $datos_generos=$conn->query($sql_generos);
    //Extraemos el id del género de la película
    $datos_pelicula=$conn->query($sql_pelicula);
    //Guardamos el id del género de la película
    $id_genero_pelicula=$datos_pelicula->fetch_assoc();
    // print_r ($id_genero);
    if($id!=0){
        $id=$id_genero_pelicula['id_genero'];
    }
    $return= "<label for='genero'>Género<select name='genero' id='genero'>";

    while($fila_generos=$datos_generos->fetch_assoc()){
        if ($fila_generos["id"]==$id){
            $return.= "<option value='$fila_generos[id]' selected>$fila_generos[genero]</option>";
        }else{
            $return.= "<option value='$fila_generos[id]'>$fila_generos[genero]</option>";
        }
    }
    $return.="</select></label><br>";
    return $return;
}
?>