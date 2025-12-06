<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClienteService;
use Illuminate\Support\Facades\Log;
use Exception;

class ClienteController extends Controller
{
    protected $service;

    public function __construct(ClienteService $service)
    {
        $this->service = $service;
    }


    public function login(Request $request)
    {
        try {
            $correo = $request->input('correo');
            $passwordd = $request->input('passwordd');

            if (empty($correo) || empty($passwordd)) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'Faltan credenciales'
                ], 400);
            }

            $rows = $this->service->getCliente($correo, $passwordd);
            $success = (!empty($rows));

            return response()->json([
                'success' => $success,
                'data' => $success ? $rows[0] : null,
                'message' => $success ? 'Cliente registrado' : 'Cliente no registrado'
            ], 200);
        } catch (Exception $e) {
            Log::error('login error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Error en el servidor'
            ], 500);
        }
    }


    public function modificar(Request $request)
    {
        try {
            $data = $request->only(['id','nombres','correo','passwordd']);

            // Forzamos id numeric
            $data['id'] = isset($data['id']) ? (int)$data['id'] : 0;

            $result = $this->service->setCliente($data);

            $success = isset($result['id']) || isset($result['update']) || (isset($data['id']) && $data['id'] > 0);
            $dataToReturn = isset($result['id']) ? $result : (isset($result['update']) ? null : null);
            $message = isset($result['id']) ? 'Cliente registrado' : (isset($result['update']) ? 'Cliente actualizado' : (isset($result['error']) ? $result['error'] : 'No se pudo registrar el cliente'));

            return response()->json([
                'success' => $success,
                'data' => $dataToReturn,
                'message' => $message
            ], $success ? 200 : 400);
        } catch (Exception $e) {
            \Log::error('store cliente error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Error en el servidor'
            ], 500);
        }
    }

    public function generarCodigo(Request $request)
    {
        try {
            $correo = $request->input('correo');

            if (empty($correo)) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'Falta correo'
                ], 400);
            }

            $rows = $this->service->generarCodigo($correo);
            $success = (!empty($rows) && !isset($rows[0]->error));

            return response()->json([
                'success' => $success,
                'data' => $success ? $rows[0] : null,
                'message' => $success ? 'Código generado' : ($rows[0]->error ?? 'Error al generar código')
            ], $success ? 200 : 400);
        } catch (Exception $e) {
            \Log::error('generarCodigo error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Error en el servidor'
            ], 500);
        }
    }
}