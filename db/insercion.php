<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/flexslider.css">
    <link rel="stylesheet" href="../css/demo.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="../img/favicon.png" rel="icon" type="image/png" />
    <title>Insertar película</title>
</head>
<body>
    <?php
    include "../elementos/topbar.php";
    include "../elementos/lista_generos.php";
    include "../elementos/lista_paises.php";
    ?>
    <h1>Insertar película</h1>
    <form class="formulario" action="insertar_peliculas.php" method="POST" enctype="multipart/form-data">
            <label for="titol">Título<input type="text" name="titol" required></label><br>
            <label for="director">Director<input type="text" name="director" required></label><br>
            <label for="any">Año<input type="text" name="any" required></label><br>
            <?php echo lista_paises();?>
            <!--<label for="pais">Pais<input type="text" name="pais" required></label><br>-->
            <label for="puntuacio">Puntuación<input type="text" name="puntuacio" required></label><br>
            <?php echo lista_generos();?>
            <input type="hidden" name="MAX_FILE_SIZE" value="5120000">
            <label for="cover">Carátula<input type="file" name="cover"></label><br>
            <input class="boton" type="submit" value="Añadir película"><br>
            <a class="boton" href="../index.php">Volver atrás</a>
        </form>
    <?php include "../elementos/footer.php";?>
</body>
</html>