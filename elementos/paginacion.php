<?php
//Comprobamos el registro actual para habilitar la navegación por las diferentes páginas
function paginacion(){
    if (!isset($_GET["registroActual"])){ //si el registroActual GET no está definido..
        $_SESSION["registroActual"] = 0; //lo pongo a cero
    }else{
        $_SESSION["registroActual"]=$_GET["registroActual"];
    }
    //Comprobamos si el siguiente registroActual sería negativo
    if (($_SESSION["registroActual"]-$_SESSION["numResultados"])<0){
        //Si es negativo lo pongo en 0
        $_SESSION["anterior"]=0;
    }else{
        //Si no, le resto 25
        $_SESSION["anterior"]=$_SESSION["registroActual"]-$_SESSION["numResultados"];
    }
    //Comprobamos si el siguiente registroActual sería superior al último registro
    if(($_SESSION["registroActual"]+$_SESSION["numResultados"])>274){
        //Si es superior le asigno el último registroActual válido
        $_SESSION["siguiente"]=274;
    }else{
        //Si no, sumamos 25
        $_SESSION["siguiente"]=$_SESSION["registroActual"]+$_SESSION["numResultados"];
    }
    return "<section class='navegador'>
    <a class='boton' href='?registroActual=$_SESSION[anterior]&numResultados=$_SESSION[numResultados]' target='_SELF'>Página anterior</a>
    <a class='boton' href='?registroActual=$_SESSION[siguiente]&numResultados=$_SESSION[numResultados]' target='_SELF'>Página siguiente</a>
    "; //enlace para recargar la pagina con el proximo registroActual de URL GET
}

function registro_actual(){    
    //Realizamos comprobaciones para los valores puestos a mano
    if($_SESSION["registroActual"]<0){
        //Si es negativo lo pongo a 0
        $indice=0;
    }elseif($_SESSION["registroActual"]>274){
        //Si es superior al último registro válido le asigno el registroActual máximo
        $indice=274;
    }else{
        //Si no se da ningún caso, le asigno el registroActual introducido a mano
        $indice=$_SESSION["registroActual"];
    }
    return $indice;
}
//Desplegable para el número de resultados a mostrar en cada página
function desplegable(){
    echo "
    <form method='GET' class='desplegable'>
        Resultados a mostrar
        <select name='numResultados'>
            <option value='25'>25</option>
            <option value='50'>50</option>
            <option value='75'>75</option>
        </select><br>
        <input type='submit' value='Enviar' class='boton'>
    </form></section>";
}
//Usamos variables de sesión para mantener el número de resultados a mostrar al cambiar de páginas
function numResultados(){
    if(!isset($_SESSION["numResultados"]) or $_SESSION["numResultados"]<=0){
            $_SESSION["numResultados"]=25;
    }elseif(isset($_GET["numResultados"])){
        $_SESSION["numResultados"]=$_GET["numResultados"];
    }
    return $_SESSION["numResultados"];
}
?>