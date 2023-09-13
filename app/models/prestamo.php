<?php
namespace Back\Models;

use \PDO;

class Prestamo {

    /**
     * Esta clase gestiona también los modelos de 'Cuota', 'Modalidad' y 'Periodicidad'.
     */
    
    private $dbh;
    
    public function __construct(DbConnection $dbh) {
        $this->dbh = $dbh;
    }
    
    /**
     * PRESTAMOS 
     */

    public function selectPrestamosList(?int $cliente_id, ?int $state_id): array {
        $sql = "SELECT * "
            . "FROM prestamos_list";
        
        $where_arr = [];

        if (!is_null($cliente_id))
            $where_arr[] = ' cliente_id = :cliente_id';

        if (!is_null($state_id)) {
            if ($state_id === -1) {
                $where_arr[] = ' state_id > 2';
            } else {
                $where_arr[] = ' state_id = :state_id';
            }
        }
        
        $where_arr_length = count($where_arr);

        if ($where_arr_length > 0) {
            $where_str = " WHERE";
            
            for ($i = 0; $i < $where_arr_length; $i++) {
                $where_str .= $where_arr[$i];
            
                if ($i != $where_arr_length - 1) {
                    $where_str .= " AND";
                }
            }
            
            $sql .= $where_str;
        }        

        $stmt = $this->dbh->prepare($sql);

        if (!is_null($cliente_id))
            $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);

        if (!is_null($state_id) && $state_id != -1)
            $stmt->bindParam(':state_id', $state_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectPrestamoDetail(int $id): array|false {
        $sql = "SELECT * "
            . "FROM prestamo_detail "
            . "WHERE id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAiPrestamos(): int {
        $sql = "SELECT AUTO_INCREMENT "
            . "FROM INFORMATION_SCHEMA.TABLES "
            . "WHERE TABLE_SCHEMA = '" . DB_NAME . "' "
            . "AND TABLE_NAME = 'prestamos'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row["AUTO_INCREMENT"];
    }

    public function getCodPrestamo(int $year): int {
        $sql = "SELECT MAX(cod) AS cod "
            . "FROM prestamos "
            . "WHERE CAST(cod AS CHAR) LIKE :crtr";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":crtr", "$year%", PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($row["cod"] ?? $year * 1e6) + 1;
    }
    
    public function insertPrestamo($id, $cod, $cliente_id, $modalidad_id, $periodicidad_id, $tasa, $asiento_id): bool {
        $sql = "INSERT INTO prestamos (id, cod, cliente_id, modalidad_id, periodicidad_id, tasa, asiento_id)
            VALUES (:id, :cod, :cliente_id, :modalidad_id, :periodicidad_id, :tasa, :asiento_id)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':cod', $cod, PDO::PARAM_STR);
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':modalidad_id', $modalidad_id, PDO::PARAM_INT);
        $stmt->bindParam(':periodicidad_id', $periodicidad_id, PDO::PARAM_INT);
        $stmt->bindParam(':tasa', $tasa, PDO::PARAM_STR);
        $stmt->bindParam(':asiento_id', $asiento_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * CUOTAS 
     */

     public function getAiCuotas(): int {
        $sql = "SELECT AUTO_INCREMENT "
            . "FROM INFORMATION_SCHEMA.TABLES "
            . "WHERE TABLE_SCHEMA = '" . DB_NAME . "' "
            . "AND TABLE_NAME = 'cuotas'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row["AUTO_INCREMENT"];
    }

    public function insertCuota($id, $prestamo_id, $cod, $capital, $interes, $fecha_vto): bool {
        $sql = "INSERT INTO cuotas (id, prestamo_id, cod, capital, interes, fecha_vto)
            VALUES (:id, :prestamo_id, :cod, :capital, :interes, :fecha_vto)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':prestamo_id', $prestamo_id, PDO::PARAM_INT);
        $stmt->bindParam(':cod', $cod, PDO::PARAM_STR);
        $stmt->bindParam(':capital', $capital, PDO::PARAM_STR);
        $stmt->bindParam(':interes', $interes, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_vto', $fecha_vto, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    /**
     * MODALIDADES
     */

    public function selectModalidades(): array {
        $sql = "SELECT * "
            . "FROM modalidades "
            . "ORDER BY id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * PEERIODICIDADES
     */

    public function selectPeriodicidades(): array {
        $sql = "SELECT * "
            . "FROM periodicidades "
            . "ORDER BY id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
