<?php
/* Archivo controlador que contiene los llamados a las acciones de la vista
   (ADD, EDIT, DELETE, SEARCH) */
  
require_once($_SERVER["DOCUMENT_ROOT"] . "/petcare-registro-eval-PIII/global.php");
require_once(__CLS_PATH . "cls_mascota.php");

class ctr_Mascota {
    private cls_Mascota $mascotaData;
    
    /**
     * Constructor del controlador
     */
    public function __construct() {
        $this->mascotaData = new cls_Mascota();
    }
    
    /**
     * Obtiene todas las mascotas
     * @return array Array con las mascotas
     */
    public function get_mascotas(): array {
        return $this->mascotaData->get_mascotas();
    }
    
    /**
     * Obtiene una mascota por su ID
     * @param int $id ID de la mascota
     * @return array|null Datos de la mascota o null si no existe
     */
    public function get_mascota_by_id(int $id): ?array {
        return $this->mascotaData->get_mascota_by_id($id);
    }
    
    /**
     * Maneja el evento de click en el botón de guardar
     * @return bool True si se guardó correctamente, false en caso contrario
     */
    public function btn_save_click(): bool {
        // Validar datos del formulario
        if (!$this->validate_form_data()) {
            return false;
        }
        
        // Preparar datos de la mascota
        $mascotaData = [
            'nombre' => htmlspecialchars($_POST['txt_nombre'], ENT_QUOTES, 'UTF-8'),
            'especie' => htmlspecialchars($_POST['sel_especie'], ENT_QUOTES, 'UTF-8'),
            'raza' => htmlspecialchars($_POST['txt_raza'], ENT_QUOTES, 'UTF-8'),
            'edad' => (int)$_POST['txt_edad'],
            'propietario' => htmlspecialchars($_POST['txt_propietario'], ENT_QUOTES, 'UTF-8'),
            'telefono' => htmlspecialchars($_POST['txt_telefono'], ENT_QUOTES, 'UTF-8')
        ];
        
        // Insertar mascota en la base de datos
        if ($this->mascotaData->insert_mascota($mascotaData)) {
            // No mostrar el mensaje aquí, deja que la vista lo maneje después
            // cls_Message::show_message("Mascota registrada correctamente", "success", "success_insert");
            return true;
        }
        
        cls_Message::show_message("Error al registrar la mascota", "error", "");
        return false;
    }
    
    /**
     * Valida los datos del formulario
     * @return bool True si los datos son válidos, false en caso contrario
     */
    private function validate_form_data(): bool {
        // Verificar que se han enviado todos los campos requeridos
        $required_fields = ['txt_nombre', 'sel_especie', 'txt_raza', 'txt_edad', 'txt_propietario', 'txt_telefono'];
        
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                cls_Message::show_message("Todos los campos son obligatorios", "error", "");
                return false;
            }
        }
        
        // Validar que la edad sea un número
        if (!is_numeric($_POST['txt_edad']) || $_POST['txt_edad'] < 0) {
            cls_Message::show_message("La edad debe ser un número válido", "error", "");
            return false;
        }
        
        // Validar que el teléfono solo contenga números
        if (!preg_match('/^[0-9]+$/', $_POST['txt_telefono'])) {
            cls_Message::show_message("El teléfono debe contener solo números", "error", "");
            return false;
        }
        
        return true;
    }
}
?>