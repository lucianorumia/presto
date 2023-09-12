<?php
namespace Back\Models;

use \PDO;

class Cliente {

    private $dbh;

    public function __construct(DbConnection $dbh) {
        $this->dbh = $dbh;
    }

    public function selectClientesList(?string $denominacion): array {
        $sql = "SELECT * "
            . "FROM clientes_list";
        
        if ($denominacion)
            $sql .= ' WHERE denominacion like :denominacion';

        $stmt = $this->dbh->prepare($sql);

        if ($denominacion)
            $stmt->bindValue(':denominacion', "%$denominacion%", PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAiClientes(): int {
        $sql = "SELECT AUTO_INCREMENT "
            . "FROM INFORMATION_SCHEMA.TABLES "
            . "WHERE TABLE_SCHEMA = '" . DB_NAME . "' "
            . "AND TABLE_NAME = 'clientes'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row["AUTO_INCREMENT"];
    }

    public function insertCliente(int $id, int $persona_id, int $created_by): bool {
        $sql = "INSERT INTO clientes (id, persona_id, created_by)
            VALUES (:id, :persona_id, :created_by)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':persona_id', $persona_id, PDO::PARAM_INT);
        $stmt->bindParam(':created_by', $created_by, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
