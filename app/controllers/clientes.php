<?php
namespace Back\Controllers;

use Back\Models\DbConnection;
use Back\Models\Cliente;
use Back\Models\Persona;

class Clientes {

    public function getClientes(?string $name = null): array {
        $dbh = new DbConnection;
        $cliente = new Cliente($dbh);
        
        return $cliente->selectClientesList($name);
    }

    public function createCliente($cliente_data, $user_id) {
        $dbh = new DbConnection;

        try {
            $dbh->beginTransaction();
            
            $persona = new Persona($dbh);
            $id_persona = $persona->getAiPersonas();
            $persona->insertPersona($id_persona, $cliente_data['nombre'], $cliente_data['apellido'], null, null, null, $cliente_data['obs']);
            
            if(!empty($cliente_data['tels'])) {
                $id_telefono = $persona->getAiTelefonos();
                foreach ($cliente_data['tels'] as $telefono) {
                    $tel_def = $telefono['def'] ? 1 : 0;
                    $persona->insertTelefono($id_telefono, $id_persona, $telefono['nro'], $telefono['tipo'], $tel_def);
                    $id_telefono ++;
                }
            }

            if(!empty($cliente_data['emails'])) {
                $id_email = $persona->getAiEmails();
                foreach ($cliente_data['emails'] as $email) {
                    $email_def = $email['def'] ? 1 : 0;
                    $persona->insertEmail($id_email, $id_persona, $email['direccion'], $email['tipo'], $email_def);
                    $id_email ++;
                }
            }

            $cliente = new Cliente($dbh);
            $id_cliente = $cliente->getAiClientes();
            $cliente->insertCliente($id_cliente, $id_persona, $user_id);
            
            $dbh->commit();

        } catch (\Throwable $th) {
            $dbh->rollBack();
            // throw...
            echo $th->getMessage();
        } finally {
            $dbh = null;
        }

    }
}