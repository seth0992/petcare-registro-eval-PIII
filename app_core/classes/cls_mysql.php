<?php
class cls_Mysql {
    private ?mysqli $conn = null;
    
    public function __construct() {}
    
    /**
     * Establece la conexión con la base de datos
     * @return mysqli Objeto de conexión
     */
    public function db_connect(): mysqli {
        if ($this->conn === null) {
            try {
                $this->conn = new mysqli("localhost", "root", "", "bd_veterinaria");
                
                if ($this->conn->connect_error) {
                    throw new Exception("Error de conexión: " . $this->conn->connect_error);
                }
                
                $this->conn->set_charset("utf8mb4");
            } catch (Exception $e) {
                cls_Message::show_message($e->getMessage(), "error", "");
                // En un entorno de producción, podrías querer registrar este error en un log
                error_log($e->getMessage());
            }
        }
        
        return $this->conn;
    }
    
    /**
     * Ejecuta una consulta SQL
     * @param string $sql Consulta SQL a ejecutar
     * @return mysqli_result|bool Resultado de la consulta
     */
    public function sql_execute(string $sql) {
        try {
            $result = $this->db_connect()->query($sql);
            
            if ($result === false) {
                throw new Exception("Error en la consulta: " . $this->conn->error);
            }
            
            return $result;
        } catch (Exception $e) {
            cls_Message::show_message($e->getMessage(), "error", ""); 
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Ejecuta una consulta preparada SQL
     * @param string $sql Consulta SQL a preparar
     * @param string $types Tipos de datos para los parámetros
     * @param array $params Parámetros para la consulta
     * @return mysqli_result|bool Resultado de la consulta
     */
    public function sql_execute_prepared(string $sql, string $types, array $params) {
        try {
            $stmt = $this->db_connect()->prepare($sql);
            
            if ($stmt === false) {
                throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
            }
            
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $stmt->close();
            
            return $result;
        } catch (Exception $e) {
            cls_Message::show_message($e->getMessage(), "error", "");
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtiene los resultados como un array indexado numéricamente
     * @param mysqli_result $result Resultado de la consulta
     * @return array Array con los resultados
     */
    public function sql_get_rows($result): array {
        try {
            $array = [];
            
            while ($row = $result->fetch_row()) {
                $array[] = $row;
            }
            
            return $array;
        } catch (Exception $e) {
            cls_Message::show_message($e->getMessage(), "error", "");
            error_log($e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtiene el resultado como un array asociativo
     * @param mysqli_result $result Resultado de la consulta
     * @return array|null Array asociativo con el resultado o null
     */
    public function sql_get_fetchassoc($result): ?array {
        try {
            return $result->fetch_assoc();
        } catch (Exception $e) {
            cls_Message::show_message($e->getMessage(), "error", "");
            error_log($e->getMessage());
            return null;
        }
    }
    
    /**
     * Cierra la conexión a la base de datos
     */
    public function close(): void {
        if ($this->conn !== null) {
            $this->conn->close();
            $this->conn = null;
        }
    }
    
    /**
     * Destructor para cerrar la conexión
     */
    public function __destruct() {
        $this->close();
    }
}
?>