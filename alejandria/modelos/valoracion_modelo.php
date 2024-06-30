<?php

class Valoracion_modelo
{
    private $table = 'valoraciones';
    private $conn;

    public function __construct()
    {
        $db = new Conectar();
        $this->conn = $db->getConnection();
    }

    public function obtener($libro_id, $user_id)
    {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE id_libro = :libro_id AND id_usuario = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':libro_id', $libro_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function guardar($id_libro, $id_usuario, $valoracion) {
        $query = "INSERT INTO " . $this->table . " (id_libro, id_usuario, valoracion, fecha)
                  VALUES (:id_libro, :id_usuario, :valoracion, NOW())";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_libro', $id_libro, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':valoracion', $valoracion, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizar($valoracion_id, $valoracion, $user_id)
    {
        $query = "UPDATE " . $this->table . " 
                  SET valoracion = :valoracion, fecha = NOW() 
                  WHERE id = :valoracion_id AND id_usuario = :id_usuario";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':valoracion_id', $valoracion_id, PDO::PARAM_INT);
        $stmt->bindParam(':valoracion', $valoracion, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function eliminar($valoracion_id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :valoracion_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':valoracion_id', $valoracion_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
