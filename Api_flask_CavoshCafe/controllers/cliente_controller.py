from services.cliente_service import ClienteService
from flask import jsonify, request

class ClienteController:

    @staticmethod
    def getCliente():
        rows = ClienteService.getCliente(request.json)
        success = len(rows) > 0
        data = rows[0] if success else None
        message = "Cliente registrado" if success else "Cliente no registrado"
        return jsonify({"success": success, "data": data, "message": message})

    @staticmethod
    def setCliente():
        rows = ClienteService.setCliente(request.json)
        success = bool(rows.get("id") or rows.get("update"))
        data = rows if rows.get("id") else None
        message = (
            "Cliente registrado" if rows.get("id")
            else "Cliente actualizado" if rows.get("update")
            else rows.get("error", "No se pudo registrar el cliente")
        )
        return jsonify({"success": success, "data": data, "message": message})

    @staticmethod
    def generarCodigo():
        rows = ClienteService.generarCodigo(request.json)
        success = len(rows) > 0 and "id" in rows[0]
        message = rows[0].get("error") if rows else "Error al generar código"
        if success:
            message = "Código generado"
        return jsonify({"success": success, "data": rows[0] if success else None, "message": message})