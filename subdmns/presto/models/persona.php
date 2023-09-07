<?php
namespace Back\Models;

use \PDO;

class Persona {

    /**
     * Esta clase gestiona también los modelos de 'Telefono', 'Email' y 'Domicilio'.
     */

    private $dbh;

    public function __construct(DbConnection $dbh) {
        $this->dbh = $dbh;
    }

    public function getAiPersonas(): int {
        $sql = "SELECT AUTO_INCREMENT "
            . "FROM INFORMATION_SCHEMA.TABLES "
            . "WHERE TABLE_SCHEMA = '" . DB_NAME . "' "
            . "AND TABLE_NAME = 'personas'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $resp = $row["AUTO_INCREMENT"];

        return $resp;
    }
    
    public function insertPersona($id, $nombre, $apellido, $documento_type_id, $documento_nro, $fecha_nac, $obs): bool {
        $sql = "INSERT INTO personas (id, nombre, apellido, documento_type_id, documento_nro, fecha_nac, obs)
            VALUES (:id, :nombre, :apellido, :documento_type_id, :documento_nro, :fecha_nac, :obs)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':documento_type_id', $documento_type_id, PDO::PARAM_INT);
        $stmt->bindParam(':documento_nro', $documento_nro, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nac', $fecha_nac, PDO::PARAM_STR);
        $stmt->bindParam(':obs', $obs, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    // Telephones
    public function getAiTelefonos(): int {
        $sql = "SELECT AUTO_INCREMENT "
            . "FROM INFORMATION_SCHEMA.TABLES "
            . "WHERE TABLE_SCHEMA = '" . DB_NAME . "' "
            . "AND TABLE_NAME = 'telefonos'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $resp = $row["AUTO_INCREMENT"];

        return $resp;
    }

    public function insertTelefono($id, $persona_id, $numero, $type_id, $principal): bool {
        $sql = "INSERT INTO telefonos (id, persona_id, numero, type_id, principal)
            VALUES (:id, :persona_id, :numero, :type_id, :principal)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':persona_id', $persona_id, PDO::PARAM_INT);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
        $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
        $stmt->bindParam(':principal', $principal, PDO::PARAM_INT);
        $res = $stmt->execute();

        return $res;
    }

    // Emails
    public function getAiEmails(): int {
        $sql = "SELECT AUTO_INCREMENT "
            . "FROM INFORMATION_SCHEMA.TABLES "
            . "WHERE TABLE_SCHEMA = '" . DB_NAME . "' "
            . "AND TABLE_NAME = 'emails'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $resp = $row["AUTO_INCREMENT"];

        return $resp;
    }

    public function insertEmail($id, $persona_id, $email, $type_id, $principal): bool {
        $sql = "INSERT INTO emails (id, persona_id, email, type_id, principal)
            VALUES (:id, :persona_id, :email, :type_id, :principal)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':persona_id', $persona_id, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
        $stmt->bindParam(':principal', $principal, PDO::PARAM_INT);
        $res = $stmt->execute();

        return $res;
    }
}
