from flask import Flask
from flask_cors import CORS
from routes.cliente_route import cliente_bp

app = Flask(__name__)
CORS(app)

app.register_blueprint(cliente_bp, url_prefix="/cliente")

if __name__ == "__main__":
    app.run(debug=True, port=4000)