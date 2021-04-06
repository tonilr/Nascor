<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/demo.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/style.css">
    <link href="img/favicon.png" rel="icon" type="image/png" />
    <script src="js/jquery.flexslider.js"></script>
    <script src="js/modernizr.js"></script>
    <title>Listado de peliculas</title>
</head>
<body>
    <!-- Insertamos la barra de navegación superior -->
    <?php include "elementos/topbar.php";?>
    <?php
    // Insertamos el slider
    include "elementos/slider.php";
    // Insertamos los elementos de paginación 
    include "elementos/paginacion.php";
    // Insertamos la lista de películas 
    include "db/peliculas_list.php";
    // include "db/insertar_peliculas.php";
    $numResultados=numResultados();
    //Llamamos a la función para dibujar los elementos de paginación
    echo paginacion();
    //Llamamos a la función para dibujar el selector de número de resultados
    echo desplegable();
    $registro_actual=registro_actual();
    //Llamamos a la función para dibujar la lista de películas
    echo imprimir_tabla($registro_actual,$numResultados);
    echo paginacion();
    echo desplegable();
    //Insertamos y dibujamos el footer
    include "elementos/footer.php";
    ?>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.min.js">\x3C/script>')</script>

    <!-- FlexSlider -->
    <script defer src="js/jquery.flexslider.js"></script>

    <script type="text/javascript">
    $(function(){
        SyntaxHighlighter.all();
    });
    $(window).load(function(){
        $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
            $('body').removeClass('loading');
        }
        });
    });
    </script>
    <!-- Syntax Highlighter -->
    <script type="text/javascript" src="js/shCore.js"></script>
    <script type="text/javascript" src="js/shBrushXml.js"></script>
    <script type="text/javascript" src="js/shBrushJScript.js"></script>
</body>
</html>