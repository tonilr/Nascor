<?php
//Datos de la conexión
function imprimir_tabla($inicio,$limite){
    $servidor="localhost";
    $usuario="filmoteca";
    $password="filmoteca";
    $bbdd="filmoteca_generos";
    //consulta
    $sql="SELECT pellicules.id,pellicules.titol,pellicules.director,pellicules.any,countries.name,pellicules.puntuacio,generos.genero FROM pellicules INNER JOIN generos ON pellicules.id_genero=generos.id INNER JOIN countries ON pellicules.id_pais=countries.id ORDER BY pellicules.titol ASC LIMIT $inicio,$limite";
    //Conexión
    $conn = new mysqli($servidor,$usuario,$password,$bbdd);
    //Comprobamos la conexión
    if ($conn->connect_error){
        return "Fallo en la conexión: $conn->connect_error";
    }
    //Ejecutamos la consulta
    $resultado= $conn->query($sql);
    // print_r($resultado);
    //Empezamos a imprimir la tabla
    if($resultado->num_rows > 0){
        $imprimir="<section class='films'>";
        while ($fila = $resultado->fetch_assoc()){
            $imprimir.="<article class='film-container'>";
            $imprimir.="<h3>".$fila['titol']."</h3><h4>".$fila['director']."</h4>";
            $id=$fila['id'];
            if (file_exists("img/covers/$id.jpg")){
                $imprimir.="<img src='img/covers/$id.jpg' class='cover'>";
            }else{
                $imprimir.="<img src='img/covers/0.jpg' class='cover'>";
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
                    $imprimir.="<img src='img/star1.png' class='puntuacio'>";
                    $punt--;
                }elseif($punt==0.5){
                    $imprimir.="<img src='img/star0.5.png' class='puntuacio'>";
                    $punt--;
                }else{
                    $imprimir.="<img src='img/star0.png' class='puntuacio'>";
                }
            }
            $imprimir.="</div>";
            //Imprimimos el enlace para la consulta en el buscador
            $titulo=$fila['titol'];
            $director=$fila['director'];
            $imprimir.="<section class='iconos'>";
            $imprimir.="<a target='_BLANK' class='icono' href='https://duckduckgo.com/?q=$titulo+$director&t=h_&ia=web'><img class='icono' src='img/search.png'></a>";
            $imprimir.="<a href='db/edit_peliculas.php?id=$id'><img class='icono' src='img/edit.png'></a>
            <a href='db/delete_peliculas.php?id=$id'><img class='icono' src='img/delete.png'></a></section>";
            $imprimir.="</article>";
        }
        $imprimir.="</section>";
    }else{
        $imprimir.="No hay resultados";
        // echo $resultado->num_rows;
    }
    //Cerramos la conexión y devolvemos el código completo de la tabla
    $conn->close();
    return $imprimir;

}
?>