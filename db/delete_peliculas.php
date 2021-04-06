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
    <title>Eliminar película</title>
</head>
<body>
    <?php include "../elementos/topbar.php";?>
    <h1>Eliminar película</h1>
    <?php
    //Datos de la conexión
    $servidor="localhost";
    $usuario="filmoteca";
    $password="filmoteca";
    $bbdd="filmoteca_generos";
    $tabla="pellicules";
    //Configuramos la conexión a la base de datos
    $conn= new mysqli($servidor,$usuario,$password,$bbdd);
    //Comprobamos si hemos llegado desde el botón de eliminar película
    if (isset($_GET["id"])){
        $id=$_GET["id"];
        $img=$id;
        //Si la película no tiene carátula, utilizamos la genérica
        if(!file_exists("../img/covers/$img.jpg")){
            $img=0;
        }
        //Consulta
        $sql="SELECT pellicules.id,pellicules.titol,pellicules.director,pellicules.any,countries.name FROM pellicules INNER JOIN countries ON pellicules.id_pais=countries.id WHERE pellicules.id=$id";
        //Guardamos el resultado de la consulta
        $query=$conn->query($sql);
        //Guardamos los valores de la película concreta
        $datos_pelicula=$query->fetch_assoc();
    //Si hemos llegado desde el botón borrar del formulario de borrado    
    }elseif(isset($_POST["borrar"])){
        //Guardamos la consulta de borrado
        $delete_query="DELETE FROM $tabla WHERE id=$_POST[id_a_borrar]";
        //Borramos el registro
        $conn->query($delete_query);
        //Cerramos la conexión y volvemos a la página principal
        $conn->close();
        header ("Location: ../");
        die();
    }else{
        //Si hemos llegado a la página sólamente escribiendo la dirección, redirigimos a la página principal
        header ("Location: ../");
    }
    //Mostramos la información de la película elegida
    echo "<section class='info_pelicula'>
            <div class='cover_pelicula'>
                <img class='portada' src='../img/covers/$img.jpg'>
            </div>
            <div class='datos_pelicula'>
                <h3>Título</h3>
                <p>$datos_pelicula[titol]</p>
                <h3>Director</h3>
                <p>$datos_pelicula[director]</p>
                <h3>Año</h3>
                <p>$datos_pelicula[any]</p>
                <h3>País</h3>
                <p>$datos_pelicula[name]</p>
            </div>
            </section>";
    ?>
    <!--Mostramos los botones para elegir si borrar o volver atrás-->
    <?php echo "<a class='boton' href='confirm_delete.php?id_a_borrar=$datos_pelicula[id]'>Borrar</a>";?>
    <a class="boton" href='../'>Volver</a>

</body>
</html>

