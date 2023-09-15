<?php
namespace Back\Controllers;

use Back\Models\DbConnection;
use Back\Models\Prestamo;
use Back\Models\Asiento;
use Back\Cross\CstmException;
use Back\Cross\CstmExceptions;

class Prestamos {

    public function createPrestamo(array $prestamo_data, int $user_id) {
        $dbh = new DbConnection;

        try {
            $dbh->beginTransaction();
            
            $year = $prestamo_data['entrega']->format('Y');

            $asiento = new Asiento($dbh);
            $id_asiento = $asiento->getAiAsientos();
            $nro = $asiento->getNroAsiento($year);
            $asiento->insertAsiento(
                $id_asiento,
                $nro,
                $prestamo_data['entrega']->format('Y-m-d'),
                'Entrega Préstamo', //hardcode!
                $user_id
            );

            $id_minuta = $asiento->getAiMinutas();
            $asiento->insertMinuta(
                $id_minuta,
                $id_asiento,
                $prestamo_data['cta_deb_id'],
                debe: $prestamo_data['monto']
            );

            $id_minuta ++;
            $asiento->insertMinuta(
                $id_minuta,
                $id_asiento,
                $prestamo_data['cta_cred_id'],
                haber: $prestamo_data['monto']
            );

            $prestamo = new Prestamo($dbh);
            $id_prestamo = $prestamo->getAiPrestamos();
            $cod = $prestamo->getCodPrestamo($year);
            $prestamo->insertPrestamo(
                $id_prestamo,
                $cod,
                $prestamo_data['cliente'],
                $prestamo_data['modalidad'],
                $prestamo_data['periodicidad'],
                $prestamo_data['tasa'],
                $id_asiento,
            );

            $id_cuota = $prestamo->getAiCuotas();
            foreach ($prestamo_data['cuotas'] as $cuota) {
                $cod = $cuota['ord'];
                $capital = $cuota['k'];
                $interes = $cuota['i'];
                $vto_date = new \DateTime($cuota['vto']);
                $fecha_vto = $vto_date->format('Y-m-d');

                $prestamo->insertCuota(
                    $id_cuota,
                    $id_prestamo,
                    $cod,
                    $capital,
                    $interes,
                    $fecha_vto
                );

                $id_cuota ++;
            }

            $dbh->commit();

        } catch (\Throwable $th) {
            $dbh->rollBack();
            throw new CstmException(CstmExceptions::SQL_ERROR, $th->getMessage());
        } finally {
            $dbh = null;
        }
    }

    public function getPrestamos(?int $cliente_id = null, ?int $state_id = null) {
        $dbh = new DbConnection;
        $prestamo = new Prestamo($dbh);
        
        return $prestamo->selectPrestamosList($cliente_id, $state_id);
    }

    public function getPrestamoDetail(int $id): array {
        $dbh = new DbConnection;
        $prestamo = new Prestamo($dbh);

        $prestamo_details = $prestamo->selectPrestamoDetail($id);
        $prestamo_cuotas = $prestamo->selectCuotasList($id);
        $prestamo_details['cuotas'] = $prestamo_cuotas;

        return $prestamo_details;
    }

    public function getModalidades(): array {
        $dbh = new DbConnection;
        $prestamo = new Prestamo($dbh);
        
        return $prestamo->selectModalidades();
    }

    public function getPeriodicidades(): array {
        $dbh = new DbConnection;
        $prestamo = new Prestamo($dbh);
        
        return $prestamo->selectPeriodicidades();
    }
}