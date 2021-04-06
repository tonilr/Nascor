<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/demo.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="../img/favicon.png" rel="icon" type="image/png" />
<title>Buscar películas</title>
</head>
<body>
    <?php include "../elementos/topbar.php";?>
    <form class="busqueda" action="buscar.php" method="POST">
        <input type="text" name="busqueda" placeholder="Introduce el texto a buscar">
        <input class="boton" type="submit">
        <a class="boton" href="../">Volver atrás</a>
    </form>
    <?php
    //Filtramos los resultados para sanear
    function sanear($input){
        $input=filter_var($input,FILTER_SANITIZE_STRING);
        return $input;
    }
    //Datos de la conexión
    function mostrar_resultados($texto){
        $servidor="localhost";
        $usuario="filmoteca";
        $password="filmoteca";
        $bbdd="filmoteca_generos";
        $tabla="pellicules";
        //consulta
        $sql="SELECT pellicules.id,pellicules.titol,pellicules.director,countries.name,pellicules.puntuacio,pellicules.any,generos.genero FROM $tabla INNER JOIN generos ON pellicules.id_genero=generos.id INNER JOIN countries ON pellicules.id_pais=countries.id WHERE pellicules.titol LIKE '%$texto%' or pellicules.director LIKE '%$texto%' or pellicules.any LIKE '%$texto%' or countries.name LIKE '%$texto%' or generos.genero LIKE '%$texto%'";
        //Conexión
        $conn = new mysqli($servidor,$usuario,$password,$bbdd);
        //Comprobamos la conexión
        if ($conn->connect_error){
            return "Fallo en la conexión: $conn->connect_error";
        }
        //Ejecutamos la consulta
        $resultado= $conn->query($sql);
        //Empezamos a imprimir la tabla
        if($resultado->num_rows > 0){
            $imprimir="<section class='films'>";
            while ($fila = $resultado->fetch_assoc()){
                $imprimir.="<article class='film-container'>";
                $imprimir.="<h3>".$fila['titol']."</h3><h4>".$fila['director']."</h4>";
                $id=$fila['id'];
                if (file_exists("../img/covers/$id.jpg")){
                    $imprimir.="<img src='../img/covers/$id.jpg' class='cover'>";
                }else{
                    $imprimir.="<img src='../img/covers/0.jpg' class='cover'>";
                }
                $imprimir.="<h4>".$fila['genero']."</h4>";
                $imprimir.="<h5>".$fila['any']."</h5>";
                $imprimir.="<h5>".$fila['name']."</h5>";
                //Comprobamos si la película contiene carátula
                
                //Transformamos la puntuación para mostrarla con estrellas
                $punt=$fila['puntuacio']/2;
                //Hacemos 5 pasadas para saber qué estrella hay que mostrar en cada paso
                $imprimir.="<div class='stars'>";
                for ($n=1;$n<=5;$n++){
                    if ($punt>=1){
                        $imprimir.="<img src='../img/star1.png' class='puntuacio'>";
                        $punt--;
                    }elseif($punt==0.5){
                        $imprimir.="<img src='../img/star0.5.png' class='puntuacio'>";
                        $punt--;
                    }else{
                        $imprimir.="<img src='../img/star0.png' class='puntuacio'>";
                    }
                }
                $imprimir.="</div>";
                //Imprimimos el enlace para la consulta en el buscador
                $titulo=$fila['titol'];
                $director=$fila['director'];
                $imprimir.="<section class='iconos'><a target='_BLANK' class='info' href='https://duckduckgo.com/?q=$titulo+$director&t=h_&ia=web'><img class='icono' src='../img/search.png'></a>";
                $imprimir.="<a href='edit_peliculas.php?id=$id'><img class='icono' src='../img/edit.png'></a>
                <a href='delete_peliculas.php?id=$id'><img class='icono' src='../img/delete.png'></a></section>";
                $imprimir.="</article>";
            }
            $imprimir.="</section>";
        }else{
            $imprimir="No hay resultados";
            // echo $resultado->num_rows;
        }
        //Cerramos la conexión y devolvemos el código completo de la tabla
        $conn->close();
        return $imprimir;

    }

    if(isset($_POST["busqueda"])){
        echo mostrar_resultados($_POST["busqueda"]);
        // echo sanear($_POST["busqueda"]);
    }
    include "../elementos/footer.php";
    ?>
</body>
</html>