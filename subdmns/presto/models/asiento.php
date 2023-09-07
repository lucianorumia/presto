<?php
namespace Back\Models;

use \PDO;

class Asiento {
    /**
     * Esta clase gestiona también los modelos de 'Cuenta' y 'Minuta'.
     */

    private $dbh;

    public function __construct(DbConnection $dbh) {
        $this->dbh = $dbh;
    }

    public function getAiAsientos(): int {
        $sql = "SELECT AUTO_INCREMENT "
            . "FROM INFORMATION_SCHEMA.TABLES "
            . "WHERE TABLE_SCHEMA = '" . DB_NAME . "' "
            . "AND TABLE_NAME = 'asientos'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row["AUTO_INCREMENT"];
    }

    public function getNroAsiento(int $ejercicio): int {
        $sql = "SELECT MAX(nro) AS nro "
            . "FROM asientos "
            . "WHERE CAST(nro AS CHAR) LIKE :crtr";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":crtr", "$ejercicio%", PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($row['nro'] ?? $ejercicio * 1e6) + 1;
    }

    public function insertAsiento($id, $nro, $fecha, $concepto, $created_by): bool {
        $sql = "INSERT INTO asientos (id, nro, fecha, concepto, created_by)
            VALUES (:id, :nro, :fecha, :concepto, :created_by)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nro', $nro, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':concepto', $concepto, PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $created_by, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * MINUTAS
     */

    public function getAiMinutas(): int {
        $sql = "SELECT AUTO_INCREMENT "
            . "FROM INFORMATION_SCHEMA.TABLES "
            . "WHERE TABLE_SCHEMA = '" . DB_NAME . "' "
            . "AND TABLE_NAME = 'minutas'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row["AUTO_INCREMENT"];
    }

    public function insertMinuta($id, $asiento_id, $cuenta_id, $debe = null, $haber = null): bool {
        $sql = "INSERT INTO minutas (id, asiento_id, cuenta_id, debe, haber)
            VALUES (:id, :asiento_id, :cuenta_id, :debe, :haber)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':asiento_id', $asiento_id, PDO::PARAM_INT);
        $stmt->bindParam(':cuenta_id', $cuenta_id, PDO::PARAM_INT);
        $stmt->bindParam(':debe', $debe, PDO::PARAM_STR);
        $stmt->bindParam(':haber', $haber, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
}
