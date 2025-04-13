<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/petcare-registro-eval-PIII/global.php");
require_once(__CLS_PATH . "cls_html.php");
require(__CTR_PATH . "ctr_mascota.php"); 

$HTML = new cls_Html();
$ctr_Mascota = new ctr_Mascota(); 

// Evento click se activa al hacer click en el botón via POST
$registro_exitoso = false;
if (isset($_POST['btn_save'])) {
    $registro_exitoso = $ctr_Mascota->btn_save_click();
    if ($registro_exitoso) {
        // Mostrar mensaje de éxito antes de la redirección
        cls_Message::show_message("Mascota registrada correctamente", "success", "success_insert");
        
        // Recargar la página para evitar reenvío del formulario
        // Usar exit después del header para asegurar que se detiene la ejecución
        header('Location: ' . __SITE_PATH__ . '?registrado=true');
        exit; // Importante: detiene la ejecución de código
    }
}
?>

<div id="registro_box">
    <h2 class="section-title">Registro de Nueva Mascota</h2>
    
    <form id="frm_registro" method="post" action="">
        <div class="form-group">
            <label for="txt_nombre">Nombre de la mascota:</label>
            <input type="text" name="txt_nombre" id="txt_nombre" class="input-field" 
                   placeholder="Ej: Firulais" required maxlength="50">
        </div>
        
        <div class="form-group">
            <label for="sel_especie">Especie:</label>
            <?php
                $especies = [
                    'perro' => 'Perro',
                    'gato' => 'Gato',
                    'ave' => 'Ave',
                    'otro' => 'Otro'
                ];
                echo $HTML->html_select('sel_especie', 'sel_especie', 'input-field', $especies, '', 'required');
            ?>
        </div>
        
        <div class="form-group">
            <label for="txt_raza">Raza:</label>
            <input type="text" name="txt_raza" id="txt_raza" class="input-field" 
                   placeholder="Ej: Labrador" required maxlength="50">
        </div>
        
        <div class="form-group">
            <label for="txt_edad">Edad (años):</label>
            <input type="number" name="txt_edad" id="txt_edad" class="input-field" 
                   placeholder="Ej: 3" required min="0" max="30">
        </div>
        
        <div class="form-group">
            <label for="txt_propietario">Nombre del propietario:</label>
            <input type="text" name="txt_propietario" id="txt_propietario" class="input-field" 
                   placeholder="Ej: Juan Pérez" required maxlength="100">
        </div>
        
        <div class="form-group">
            <label for="txt_telefono">Teléfono del propietario:</label>
            <input type="tel" name="txt_telefono" id="txt_telefono" class="input-field" 
                   placeholder="Ej: 88889999" required maxlength="15">
        </div>
        
        <div class="button-container">
            <button type="submit" name="btn_save" id="btn_save" class="button">
                <span class="button-icon">🐾</span> Registrar Mascota
            </button>
        </div>
    </form>
</div>

<div id="main_panel">
    <h2 class="panel-title">Mascotas Registradas</h2>

    <?php
        $row = $ctr_Mascota->get_mascotas(); // Obtenemos el array de mascotas
        
        if (empty($row)) {
            echo "<div class='no-items'>
                    <p>No hay mascotas registradas aún.</p>
                    <div class='empty-icon'>🐾</div>
                  </div>";
        } else {
            echo "<div class='mascota-grid'>";
            
            foreach($row as $value) {
                $mascota_id = htmlspecialchars($value[0], ENT_QUOTES, 'UTF-8');
                $mascota_nombre = htmlspecialchars($value[1], ENT_QUOTES, 'UTF-8');
                $mascota_especie = htmlspecialchars($value[2], ENT_QUOTES, 'UTF-8');
                $mascota_propietario = htmlspecialchars($value[3], ENT_QUOTES, 'UTF-8');
                
                echo "<a href='detalles.php?id={$mascota_id}' class='mascota-card'>
                        <div class='mascota-icon'>
                            " . ($mascota_especie == 'perro' ? '🐕' : ($mascota_especie == 'gato' ? '🐈' : ($mascota_especie == 'ave' ? '🦜' : '🐾'))) . "
                        </div>
                        <h3>{$mascota_nombre}</h3>
                        <p><strong>Especie:</strong> {$mascota_especie}</p>
                        <p><strong>Propietario:</strong> {$mascota_propietario}</p>
                        <div class='mascota-more'>Ver detalles →</div>
                      </a>";
            }
            
            echo "</div>";
        }
    ?>
</div>

<?php if (isset($_GET['registrado']) && $_GET['registrado'] === 'true'): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar mensaje de éxito
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success';
        alertDiv.textContent = 'Mascota registrada correctamente';
        document.getElementById('registro_box').insertBefore(alertDiv, document.getElementById('frm_registro'));
        
        // Auto-eliminar mensaje después de 5 segundos
        setTimeout(function() {
            alertDiv.style.opacity = '0';
            setTimeout(function() {
                alertDiv.remove();
            }, 500);
        }, 5000);
        
        // Limpiar formulario
        document.getElementById('frm_registro').reset();
    });
</script>
<?php endif; ?>