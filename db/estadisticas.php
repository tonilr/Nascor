<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/flexslider.css">
    <link rel="stylesheet" href="../css/demo.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="../img/favicon.png" rel="icon" type="image/png" />

    <title>Estadísticas</title>
</head>
<body>
    <?php include "../elementos/topbar.php";?>

    <section id="sectionchart">
        <h2>Top 10 películas por países</h2>
        <div id="chartpelisdiv"></div><br>
        <h2>Top 10 películas por género</h2>
        <div id="chartgenerosdiv"></div>
    </section>
    <script src="../js/core.js"></script>
    <script src="../js/charts.js"></script>
    <script src="../js/animated.js"></script>
    <script src="../js/estadisticas.js"></script>
</body>
</html>