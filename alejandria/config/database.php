<?php 

/* En este archivo establecemos conexión con la base de datos */

// Creamos una clase para la conexión
class Conectar {

    // Definimos variables con los datos de acceso
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "bd_libreria";
    private $conn;

    // Constructor de la clase para establecer la conexión
    public function __construct() {

        // Utilizamos try/catch para manejar los posibles errores de conexión
        try {

            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);

        } catch(PDOException $e) {

            die("Error de conexión: " . $e->getMessage());
            
        }

    }

    // Método para obtener la conexión
    public function getConnection() {

        return $this->conn;
        
    }
    
}
    
?>