<?php
    require_once("global.php");
    require_once(__CLS_PATH . "cls_html.php");
    require_once(__CTR_PATH . "ctr_mascota.php");
    
    $HTML = new cls_Html();
    $ctr_Mascota = new ctr_Mascota();
    
    // Verificar si se ha proporcionado un ID válido
    if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
        // Redirigir al índice si no hay ID válido
        header('Location: ' . __SITE_PATH__);
        exit;
    }
    
    $mascota = $ctr_Mascota->get_mascota_by_id($_GET['id']);
    
    // Si la mascota no existe, redirigir al índice
    if (empty($mascota)) {
        header('Location: ' . __SITE_PATH__);
        exit;
    }
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
        <title>Detalles de <?php echo htmlspecialchars($mascota['nombre']); ?> - PetCare Registro</title>
    </head>
    
    <body id="main_page">
        <div id="main_box">
            <header>
                <h1 class="site-title">PetCare Registro</h1>
                <p class="site-description">Detalles de la mascota</p>
            </header>
            
            <div id="detalle_mascota">
                <div class="detalle_card">
                    <h2><?php echo htmlspecialchars($mascota['nombre']); ?></h2>
                    <div class="detalle_info">
                        <p><strong>Especie:</strong> <?php echo htmlspecialchars($mascota['especie']); ?></p>
                        <p><strong>Raza:</strong> <?php echo htmlspecialchars($mascota['raza']); ?></p>
                        <p><strong>Edad:</strong> <?php echo htmlspecialchars($mascota['edad']); ?> años</p>
                        <p><strong>Propietario:</strong> <?php echo htmlspecialchars($mascota['propietario']); ?></p>
                        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($mascota['telefono']); ?></p>
                        <p><strong>Fecha de registro:</strong> <?php 
                            $fecha = new DateTime($mascota['fecha_registro']);
                            echo $fecha->format('d/m/Y H:i'); 
                        ?></p>
                    </div>
                </div>
                
                <div class="button-container">
                    <a href="<?php echo __SITE_PATH__; ?>" class="button back-button">
                        <span class="button-icon">←</span> Volver al listado
                    </a>
                </div>
            </div>
            
            <footer>
                <p>PetCare Registro &copy; <?php echo date('Y'); ?> - Todos los derechos reservados</p>
            </footer>
        </div>
    </body>
</html>