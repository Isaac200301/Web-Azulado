import mysql.connector

# Conexión a la base de datos
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="azulado"
)
cursor = conexion.cursor()

# Obtener datos de la tabla precios_por_tamano
query_select = "SELECT id, precio_compra FROM precios_por_tamano"
cursor.execute(query_select)
resultados = cursor.fetchall()

# Actualizar precios de venta aumentando un 35%
for resultado in resultados:
    id_registro = resultado[0]
    precio_compra = float(resultado[1])  # Convertir a float
    
    # Calcular el precio de venta aumentando un 35%
    precio_venta = int(precio_compra * 1.35)

    # Actualizar el registro en la tabla
    query_update = "UPDATE precios_por_tamano SET precio_venta = %s WHERE id = %s"
    values_update = (precio_venta, id_registro)
    cursor.execute(query_update, values_update)

# Confirmar los cambios y cerrar la conexión
conexion.commit()
conexion.close()

print("Precios de venta actualizados correctamente.")

