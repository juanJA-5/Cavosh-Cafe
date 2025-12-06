from bd.db import get_connection

class ClienteService:

    @staticmethod
    def getCliente(data):
        correo = data.get("correo")
        passwordd = data.get("passwordd")

        conn = get_connection()
        cursor = conn.cursor(dictionary=True)

        cursor.callproc("sp_getCliente", [correo, passwordd])
        rows = []
        for result in cursor.stored_results():
            rows = result.fetchall()

        cursor.close()
        conn.close()
        return rows

    @staticmethod
    def setCliente(data):
        conn = get_connection()
        cursor = conn.cursor(dictionary=True)

        id_cliente = data.get("id")

        cursor.callproc("sp_setCliente", list(data.values()))

        # Recoger resultados
        result_rows = []
        for result in cursor.stored_results():
            result_rows = result.fetchall()

        cursor.close()
        conn.commit()
        conn.close()

        # Insert
        if id_cliente == 0 and result_rows and result_rows[0].get("insertID"):
            data["id"] = result_rows[0]["insertID"]
            return data

        # Error
        if result_rows:
            return {"error": result_rows[0].get("error")}

        return {"update": True}

    @staticmethod
    def generarCodigo(data):
        correo = data.get("correo")

        conn = get_connection()
        cursor = conn.cursor(dictionary=True)

        cursor.callproc("sp_getClienteCodigo", [correo])

        rows = []
        for result in cursor.stored_results():
            rows = result.fetchall()

        cursor.close()
        conn.close()
        return rows