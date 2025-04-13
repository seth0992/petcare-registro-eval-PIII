<?php
    require_once("global.php");
    require_once(__CLS_PATH . "cls_html.php");
    
    $HTML = new cls_Html();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PetCare Registro - Sistema de registro de mascotas para veterinaria">
        <?php
            // Incluir jQuery
            echo $HTML->html_js_header("https://code.jquery.com/jquery-3.6.0.min.js");
            
            // Incluir archivo de funciones JS propio
            echo $HTML->html_js_header(__JS_PATH . "functions.js");
            
            // Incluir CSS
            echo $HTML->html_css_header(__CSS_PATH . "style.css", "screen");
        ?>
        <title>PetCare Registro - Sistema Veterinario</title>
    </head>
    
    <body id="main_page">
        <div id="main_box">
            <header>
                <h1 class="site-title">PetCare Registro</h1>
                <p class="site-description">Sistema de registro de mascotas para veterinaria</p>
            </header>
            
            <?php
                include_once(__VWS_PATH . "registro.php");
            ?>
            
            <footer>
                <p>PetCare Registro &copy; <?php echo date('Y'); ?> - Todos los derechos reservados</p>
            </footer>
        </div>
    </body>
</html>