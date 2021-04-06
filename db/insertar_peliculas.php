<?php
    //Comprobamos si se han rellenado todos los campos
    if (isset($_POST["titol"]) and isset($_POST["director"]) and isset($_POST["any"]) and isset($_POST["pais"]) and isset($_POST["puntuacio"])){
        $titol=$_POST["titol"];
        $director=$_POST["director"];
        $any=$_POST["any"];
        $pais=$_POST["pais"];
        $puntuacio=$_POST["puntuacio"];
        $genero=$_POST["genero"];
        //Llamamos a la función y le pasamos los parámetros del formulario
        insertar_pelicula($titol,$director,$any,$pais,$puntuacio,$genero);
        }
    
    function insertar_pelicula($titol,$director,$any,$pais,$puntuacio,$genero){
        //Configuramos la conexión a la base de datos
        $servidor="localhost";
        $usuario="filmoteca";
        $password="filmoteca";
        $bbdd="filmoteca_generos";
        $tabla="pellicules";
        //consulta para insertar datos de la película
        $sql="INSERT INTO pellicules VALUES (NULL, '$titol' , '$director' , '$any' , '','$pais' , '0' , '0' , '$puntuacio' , NULL , current_timestamp(), '$genero')";
        //Conexión a la base de datos
        $conn = new mysqli($servidor,$usuario,$password,$bbdd);
        //Comprobamos la conexión
        if ($conn->connect_error){
            return "Fallo en la conexión: $conn->connect_error";
        }
        // Ejecutamos la consulta de inserción de la nueva película
        $conn->query($sql);
        $maxsize=512000;
        $filetype=$_FILES["cover"]["type"];
        // Comprobamos si se ha añadido una carátula
        if (file_exists($_FILES["cover"]["tmp_name"]) and ($_FILES["cover"]["size"]<=$maxsize) and ((strpos($filetype,"jpg")) or (strpos($filetype,"jpeg")) or (strpos($filetype,"png")))){
            //Consulta para obtener el id del nuevo registro
            $queryid="SELECT `id` FROM `pellicules` WHERE `titol`='$titol' ORDER BY `data_creacio` DESC LIMIT 1";
            //Guardamos el resultado de la consulta
            $query=$conn->query($queryid);
            //Guardamos los valores de la consulta
            $fila=$query->fetch_assoc();
            // print_r($fila);
            //Guardamos el valor id del registro insertado
            $id=$fila["id"];
            // echo $id;
            //Guardamos la carátula con el número de id del nuevo registro
            move_uploaded_file($_FILES["cover"]["tmp_name"],"../img/covers/$id.jpg");
            // echo "Carátula subida";
        }
        //Cerramos la conexión
        $conn->close();
        //Recargamos la página una vez añadida la película
        header("Location: /demos/BBDD/ejercicios/amcharts/");
        die();
        
    }

?>
