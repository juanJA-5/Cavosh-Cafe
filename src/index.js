import express from "express"
import cors from "cors";

import clienteRoutes from "./routes/v1/cliente.route.js";

// import appRouter from "./v1/router"


const app = express()

app.use( cors() )
app.use( express.json() )

app.use("/api/v1/cliente", clienteRoutes)

app.listen(3000, () => { console.log("running server") } )