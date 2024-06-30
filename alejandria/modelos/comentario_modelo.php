<?php

class Comentario_modelo
{
    private $table = 'comentarios';
    private $conn;

    // Establecemos la conexión con la base de datos
    public function __construct()
    {
        $db = new Conectar();
        $this->conn = $db->getConnection();
    }

    public function obtener($user_id = null, $id_libro = null)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE 1=1";
    
        // Agregar condiciones basadas en los parámetros
        if ($user_id !== null) {
            $query .= " AND id_usuario = :id_usuario";
        }
        if ($id_libro !== null) {
            $query .= " AND id_libro = :id_libro";
        }
    
        $stmt = $this->conn->prepare($query);
    
        // Enlazar parámetros si existen
        if ($user_id !== null) {
            $stmt->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);
        }
        if ($id_libro !== null) {
            $stmt->bindParam(':id_libro', $id_libro, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Guarda el comentario de un usuario sobre un libro
    public function guardar($user_id, $id_libro, $contenido)
    {
        try {
            $query = "INSERT INTO " . $this->table . " (id_libro, id_usuario, contenido, fecha) VALUES (:id_libro, :user_id, :contenido, NOW())";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_libro', $id_libro);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':contenido', $contenido);

            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al guardar comentario: " . $e->getMessage());
            return false;
        }
    }

    // Obtenemos todos los comentarios de un libro por cualquier usuario
    function obtener_comentarios_libro($idApi)
    {
        $query = "SELECT 
                c.id AS comentario_id,
                c.contenido,
                c.fecha,
                u.nombre AS usuario_nombre, 
                u.foto AS usuario_foto,
                l.titulo AS libro_titulo,
                l.autor AS libro_autor,
                l.descripcion AS libro_descripcion,
                l.portada AS libro_portada
            FROM 
                comentarios c
            JOIN 
                libros l ON c.id_libro = l.id
            JOIN 
                usuarios u ON c.id_usuario = u.id
            WHERE 
                l.idApi = :idApi
            ORDER BY 
                c.fecha DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idApi', $idApi, PDO::PARAM_STR);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    // Obtenemos todos los comentarios de un usuario
    public function obtener_comentarios_usuario($user_id)
    {
        $query = "SELECT c.id AS comentario_id, c.contenido, c.fecha, l.titulo AS libro_titulo, l.autor AS libro_autor
                  FROM " . $this->table . " c
                  JOIN libros l ON c.id_libro = l.id
                  WHERE c.id_usuario = :user_id
                  ORDER BY c.fecha DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    // Obtenemos los comentarios de un libro escritos por el usuario
    public function obtener_comentarios_usuario_libro($user_id, $id_libro)
    {
        $query = "SELECT c.id AS comentario_id, c.contenido, c.fecha, l.titulo AS libro_titulo, l.autor AS libro_autor
                  FROM " . $this->table . " c
                  JOIN libros l ON c.id_libro = l.id
                  WHERE c.id_usuario = :user_id AND id_libro = :id_libro
                  ORDER BY c.fecha DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_libro', $id_libro, PDO::PARAM_INT);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function actualizar($user_id, $id_comentario, $nuevo_contenido)
    {
        $query = "UPDATE " . $this->table . " SET contenido = :nuevo_contenido WHERE id = :id_comentario AND id_usuario = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nuevo_contenido', $nuevo_contenido);
        $stmt->bindParam(':id_comentario', $id_comentario);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }

    public function eliminar($user_id, $id_comentario)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id_comentario AND id_usuario = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_comentario', $id_comentario);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }
}
