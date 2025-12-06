import mysql.connector
from mysql.connector import pooling
import config

dbconfig = {
    "host": config.DB_HOST,
    "port": config.DB_PORT,
    "user": config.DB_USER,
    "password": config.DB_PASSWORD,
    "database": config.DB_DATABASE,
}

pool = pooling.MySQLConnectionPool(pool_name="mypool", pool_size=5, **dbconfig)

def get_connection():
    return pool.get_connection()