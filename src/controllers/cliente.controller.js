import { service } from "../services/cliente.service.js";

const getCliente = async (req, res) => {
    const rows = await service.getCliente(req, res)
    const success = rows[0].length > 0
    const data = success ? rows[0][0] : null
    const message = success ? "Cliente registrado" : "CLiente no registrado"
    res.send( { success, data, message } )
}

const setCliente = async (req, res) => {
    const rows = await service.setCliente(req, res)
    const success = rows.id || rows.update ? true : false
    const data = rows.id ? rows : null
    const message =  rows.id ? "Cliente registrado" : rows.update ? "Cliente actualizado" : rows.error ? rows.error : "No se pudo registrar el cliente"
    res.send( { success, data, message } )
}
const generarCodigo = async (req, res) => {
    const rows = await service.generarCodigo(req, res);
    const success = rows[0]?.id ? true : false;
    const message = rows[0]?.error || (success ? "Código generado" : "Error al generar código");
    res.send({ success, data: success ? rows[0] : null, message });
};

export const controller = {
    getCliente, setCliente,generarCodigo

}
