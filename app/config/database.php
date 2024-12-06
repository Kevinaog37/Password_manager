<?php
require_once "config.php";
class database
{
    private $username = DB_USER;
    private $password = DB_PASS;

    private $error = "";

    private $connection;

    public function connect()
    {
        try {
            $this->connection = new PDO(
                SGBD,
                $this->username,
                $this->password
            );

            // Configurar PDO para que lance excepciones en caso de error
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            die("Error en la conexión a la base de datos: " . $e->getMessage());
        }
    }

    // Método para obtener la conexión PDO
    public function getConnection()
    {
        return $this->connection;
    }

    // Método para realizar consultas
    /**
     * Ejecuta una consulta SQL.
     *
     * @param string $sql Consulta SQL con parámetros.
     * @param array $params Parámetros para la consulta.
     * @return array|bool Resultado de la consulta o `false` si falla.
     */
    public function query(string $sql, array $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);

            // Verificar si es SELECT o una operación de escritura
            if (stripos($sql, 'SELECT') === 0) {
                return $stmt->fetchAll();
            }

            return $stmt->rowCount(); // Devuelve el número de filas afectadas
        } catch (PDOException $e) {
            // Manejo de errores
            $this->error = "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

    public function getError(){
        return $this->error;
    }
}
