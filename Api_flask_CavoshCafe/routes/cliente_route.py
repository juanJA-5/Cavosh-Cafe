from flask import Blueprint
from controllers.cliente_controller import ClienteController

cliente_bp = Blueprint("cliente", __name__)

cliente_bp.route("/login", methods=["POST"])(ClienteController.getCliente)
cliente_bp.route("/", methods=["POST"])(ClienteController.setCliente)
cliente_bp.route("/codigo", methods=["POST"])(ClienteController.generarCodigo)