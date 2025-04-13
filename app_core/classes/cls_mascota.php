<?php 
require_once(__CLS_PATH . "cls_mysql.php");

class cls_Mascota {
    private cls_Mysql $data_provide;

    public function __construct() {
        $this->data_provide = new cls_Mysql();
    }
    
    /**
     * Obtiene todas las mascotas ordenadas por fecha de registro
     * @return array Lista de mascotas
     */
    public function get_mascotas(): array {
        $result = $this->data_provide->sql_execute(
            "SELECT id, nombre, especie, propietario FROM tbl_mascotas ORDER BY fecha_registro DESC"
        );

        if ($result === false) {
            return [];
        }

        return $this->data_provide->sql_get_rows($result);
    }
    
    /**
     * Obtiene una mascota por su ID
     * @param int $id ID de la mascota
     * @return array|null Datos de la mascota o null si no existe
     */
    public function get_mascota_by_id(int $id): ?array {
        $result = $this->data_provide->sql_execute_prepared(
            "SELECT * FROM tbl_mascotas WHERE id = ? LIMIT 1",
            "i",
            [$id]
        );

        if ($result === false) {
            return null;
        }

        return $this->data_provide->sql_get_fetchassoc($result);
    }

    /**
     * Inserta una nueva mascota en la base de datos
     * @param array $mascotaData Datos de la mascota
     * @return bool True si se insertó correctamente, false en caso contrario
     */
    public function insert_mascota(array $mascotaData): bool {
        if (empty($mascotaData)) {
            return false;
        }

        $result = $this->data_provide->sql_execute_prepared(
            "INSERT INTO tbl_mascotas (nombre, especie, raza, edad, propietario, telefono, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?)",
            "sssisss",
            [
                $mascotaData['nombre'],
                $mascotaData['especie'],
                $mascotaData['raza'],
                $mascotaData['edad'],
                $mascotaData['propietario'],
                $mascotaData['telefono'],
                date('Y-m-d H:i:s')
            ]
        );

        return $result !== false;
    }
}
?>