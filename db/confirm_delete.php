<?php
    if (isset($_POST["id_a_borrar"])){
        //Datos de la conexión
        $servidor="localhost";
        $usuario="filmoteca";
        $password="filmoteca";
        $bbdd="filmoteca_generos";
        $tabla="pellicules";
        //Configuramos la conexión a la base de datos
        $conn= new mysqli($servidor,$usuario,$password,$bbdd);
        //Guardamos la consulta de borrado
        $delete_query="DELETE FROM $tabla WHERE id=$_POST[id_a_borrar]";
        //Borramos el registro
        if ($conn->query($delete_query)){
            if (file_exists("../img/covers/$_POST[id_a_borrar].jpg")){
                unlink("../img/covers/$_POST[id_a_borrar].jpg");
            }
                $conn->close();
                header ("Location: /demos/BBDD/ejercicios/amcharts/");
        }else{
            $conn->close();
            header ("Location: /demos/BBDD/ejercicios/amcharts/");
        }
    //Cerramos la conexión y volvemos a la página principal
    }elseif(isset($_POST["volver"]) or !isset($_GET["id_a_borrar"])){
        header ("Location: /demos/BBDD/ejercicios/amcharts/");
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/demo.css">
    <link rel="stylesheet" href="../css/flexslider.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="../img/favicon.png" rel="icon" type="image/png" />
    <title>Confirmar borrado</title>
</head>
<body>
    <?php include "../elementos/topbar.php";?>
    <h1>Confirmar borrado de película</h1>
    <h2>Estás seguro de querer borrar la película?</h2>

    <form action="confirm_delete.php" method="POST">
        <input type="hidden" name="id_a_borrar" value="<?php echo $_GET['id_a_borrar'];?>">
        <input class="boton" type="submit" name="borrar" value="Sí">
    </form>
    <form action="confirm_delete.php" method="POST">
        <input class="boton" type="submit" name="volver" value="No">
    </form>

</body>
</html>