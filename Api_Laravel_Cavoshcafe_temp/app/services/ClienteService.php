<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

class ClienteService
{
    
    public function getCliente(string $correo, string $passwordd)
    {
        try {
            $rows = DB::select('CALL sp_getCliente(?, ?)', [$correo, $passwordd]);
            return $rows; // array de objetos
        } catch (Exception $e) {
            // Lanzamos la excepción para que el controller la maneje
            throw $e;
        }
    }

  
    public function setCliente(array $data)
    {
        try {
            $id = $data['id'] ?? 0;
            $nombres = $data['nombres'] ?? null;
            $correo = $data['correo'] ?? null;
            $passwordd = $data['passwordd'] ?? null;

            $rows = DB::select('CALL sp_setCliente(?, ?, ?, ?)', [
                (int)$id,
                $nombres,
                $correo,
                $passwordd
            ]);

          
            if ($id == 0) {
                if (!empty($rows) && isset($rows[0]->insertID)) {
                    $data['id'] = (int)$rows[0]->insertID;
                    return $data;
                }
                if (!empty($rows) && isset($rows[0]->error)) {
                    return ['error' => $rows[0]->error];
                }
            } else {
                if (!empty($rows) && isset($rows[0]->error)) {
                    return ['error' => $rows[0]->error];
                }
                return ['update' => true];
            }

            return ['update' => true];
        } catch (Exception $e) {
            throw $e;
        }
    }

    
    public function generarCodigo(string $correo)
    {
        try {
            $rows = DB::select('CALL sp_getClienteCodigo(?)', [$correo]);
            return $rows;
        } catch (Exception $e) {
            throw $e;
        }
    }
}