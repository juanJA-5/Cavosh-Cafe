import { pool } from '../db/db.js'

const getCliente = async (req, res) => {
    const { correo, passwordd } = req.body
    const rows = await pool.query('call sp_getCliente(?,?)', [correo,passwordd])
    return ( rows[0] )
}

const setCliente = async (req, res) => {
    const id = req.body.id
    const [ rows ] = await pool.query('call sp_setCliente(?,?,?,?)', [ ...Object.values( req.body ) ])

    if ( id == 0 && rows[0][0].insertID ) {
        req.body.id = rows[0][0].insertID
        return ( req.body )
    }
    if ( typeof rows[0] != 'undefined' ) return ( { "error" : rows[0][0].error } )
    return ( { "update" : true } )
}
 
const generarCodigo=async(req,res)=>{
    const{correo}=req.body;
    cons[rows]=await pool.query('call sp_getClienteCodigo(?)', [correo]);
    return rows[0];
}
export const service = {
    getCliente, setCliente,generarCodigo
}