import { controller } from "../../controllers/cliente.controller.js";
import { Router } from "express";

const clienteRoutes = Router();

clienteRoutes
    .get("/login", controller.getCliente)
    .post("/", controller.setCliente)
    .post("/codigo", controller.generarCodigo);

export default clienteRoutes;
