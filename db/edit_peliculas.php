<?php
include "../elementos/lista_generos.php";
include "../elementos/lista_paises.php";
if (isset($_GET["id"])){
        $id=filter_var($_GET["id"],FILTER_SANITIZE_NUMBER_INT);
    }elseif (!isset($_POST["titol"]) or $_POST["titol"]=="" or !isset($_POST["director"]) or $_POST["director"]=="" or !isset($_POST["any"]) or $_POST["any"]=="" or !isset($_POST["pais"]) or $_POST["pais"]=="" or !isset($_POST["puntuacio"]) or $_POST["puntuacio"]==""){
        header ("Location: /");
        die();
    }else{
        $titol=$_POST["titol"];
        $director=$_POST["director"];
        $any=$_POST["any"];
        $pais=$_POST["pais"];
        $puntuacio=$_POST["puntuacio"];
        $id=$_POST["id"];
        $genero=$_POST["genero"];
        //Llamamos a la función y le pasamos los parámetros del formulario
        editar_pelicula($id,$titol,$director,$any,$pais,$puntuacio,$genero);
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/demo.css">
    <link rel="stylesheet" href="../css/flexslider.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="../img/favicon.png" rel="icon" type="image/png" />

    <title>Editar películas</title>
</head>
<body>
    <?php
    include "../elementos/topbar.php";
    ?>
    <h1>Editar información de película</h1>
    <?php
    
    //Datos de la conexión
    $servidor="localhost";
    $usuario="filmoteca";
    $password="filmoteca";
    $bbdd="filmoteca_generos";
    $tabla="pellicules";
    //Consulta
    $sql="SELECT pellicules.id,pellicules.titol,pellicules.director,pellicules.any,countries.name,pellicules.puntuacio,generos.genero FROM pellicules INNER JOIN countries ON pellicules.id_pais=countries.id INNER JOIN generos ON pellicules.id_genero=generos.id WHERE pellicules.id=$id";
    // print_r($sql);
    //Conexión
    $conn = new mysqli($servidor,$usuario,$password,$bbdd);
    //Ejecutamos y guardamos la consulta a la BBDD
    $consulta=$conn->query($sql);
    // print_r($consulta);
    $datos_pelicula=$consulta->fetch_assoc();
    // echo "<br>";
    // print_r($datos_pelicula);
    if (!file_exists("../img/covers/$id.jpg")){
        $img=0;
    }else{
        $img=$id;
    }
    ?>
    <form action="edit_peliculas.php" method="POST" class="formulario" enctype="multipart/form-data">
        <label for="titol">Título<input type="text" name="titol" value="<?php echo $datos_pelicula['titol']?>"  required></label><br>
        <label for="director">Director<input type="text" name="director" value="<?php echo $datos_pelicula['director']?>" required></label><br>
        <label for="any">Año<input type="text" name="any" value="<?php echo $datos_pelicula['any']?>"  required></label><br>
        <?php echo lista_paises($id);?>
        <!--<label for="pais">Pais<input type="text" name="pais" value="<?php echo $datos_pelicula['name']?>"  required></label><br>-->
        <label for="puntuacio">Puntuación<input type="text" name="puntuacio" value="<?php echo $datos_pelicula['puntuacio']?>"></label><br>
        <?php echo lista_generos($id);?>
        <input type="hidden" name="id" value="<?php echo $datos_pelicula['id'];?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="5120000">
        <label for="cover">Carátula<input type="file" name="cover"></label><br>
        <?php echo "<img src='../img/covers/$img.jpg'>";?>
        <input type="submit" class="boton" value="Editar película">
        <a class="boton" href="../index.php">Volver</a>
    </form>
    <?php
    //Comprobamos si se han rellenado todos los campos
   
    
    function editar_pelicula($id,$titol,$director,$any,$pais,$puntuacio,$genero){
        //Configuramos la conexión a la base de datos
        $servidor="localhost";
        $usuario="filmoteca";
        $password="filmoteca";
        $bbdd="filmoteca_generos";
        $tabla="pellicules";;
        //consulta para insertar datos de la película
        $sql="UPDATE $tabla SET `titol`='$titol', `director`='$director' ,`any`='$any', `id_pais`='$pais', `puntuacio`='$puntuacio', `id_genero`='$genero' WHERE `id`='$id'";
        //Conexión a la base de datos
        $conn = new mysqli($servidor,$usuario,$password,$bbdd);
        //Comprobamos la conexión
        if ($conn->connect_error){
            return "Fallo en la conexión: $conn->connect_error";
        }
        //print_r ($conn);
        // Ejecutamos la consulta de inserción de la nueva película
        $conn->query($sql);
        // Comprobamos si se ha añadido una carátula
        if (file_exists($_FILES["cover"]["tmp_name"])){
            $filesize=$_FILES["cover"]["size"];
            $filetype=$_FILES["cover"]["type"];
            //Comprobamos si el tipo de archivo y el tamaño son correctos
            if (($filesize < 51200) and ((strpos($filetype,"jpg") or strpos($filetype,"jpeg")))){
                //Guardamos la carátula con el número de id del nuevo registro
                move_uploaded_file($_FILES["cover"]["tmp_name"],"../img/covers/$id.jpg");
            }
        }
        //Cerramos la conexión
        $conn->close();
        //Recargamos la página una vez añadida la película
        //print_r($_POST);
        header("Location: ../");
        die();
        
    }
    include "../elementos/footer.php";
    ?>
</body>
</html>

