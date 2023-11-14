import json
import mysql.connector

# Cargar el JSON desde el archivo
with open("python\datos_compra.json", "r") as json_file:
    data_json = json.load(json_file)

# Conexión a la base de datos
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="azulado"
)
cursor = conexion.cursor()

# Función para obtener el ID de un tamaño dado su nombre
def obtener_id_tamano(nombre):
    query = "SELECT id FROM tamanos WHERE nombre = %s"
    cursor.execute(query, (nombre,))
    result = cursor.fetchone()
    if result:
        return result[0]
    else:
        return None

# Función para obtener el ID de un producto dado su nombre
def obtener_id_producto(nombre):
    query = "SELECT id FROM productos WHERE nombre = %s"
    cursor.execute(query, (nombre,))
    result = cursor.fetchone()
    if result:
        return result[0]
    else:
        return None

# Insertar precios de compra en la tabla precios_por_tamano
for producto in data_json:
    nombre_producto = producto["DESCRIPCIÓN PRODUCTO"]
    presentacion = producto["PRESENTACION"]
    precio_compra_str = producto["P. VENTA\rANTES DE\rIVA"].replace("$", "").replace(",", "").strip()
    
    # Multiplicar por 100 antes de convertir a entero
    precio_compra = (float(precio_compra_str) * 1000)

    # Obtener directamente el tamaño_id y producto_id desde las funciones
    tamano_id = obtener_id_tamano(presentacion)
    producto_id = obtener_id_producto(nombre_producto)

    # Insertar en la tabla precios_por_tamano
    if tamano_id is not None and producto_id is not None:
        query_insert = "INSERT INTO precios_por_tamano (producto_id, tamano_id, precio_compra) VALUES (%s, %s, %s)"
        values_insert = (producto_id, tamano_id, precio_compra)
        cursor.execute(query_insert, values_insert)

# Confirmar los cambios y cerrar la conexión
conexion.commit()
conexion.close()

print("Precios de compra agregados correctamente.")
