import json

# Cargar el JSON desde el archivo
with open("python\datos_compra.json", "r") as json_file:
    datos_compra_json = json.load(json_file)

# Crear SQL para insertar productos con stock en cero
sql_insert = "INSERT INTO productos (nombre, stock) VALUES "
values = set()

for producto in datos_compra_json:
    nombre = producto['DESCRIPCIÓN PRODUCTO']
    presentacion = producto['PRESENTACION']  # Cambiado a 'tamano' según el JSON
    
    # Ignorar productos sin presentación y evitar duplicados
    if presentacion != "nan":
        if presentacion and nombre not in values:
            values.add(nombre)
            sql_insert += f"('{nombre}', 0), "

# Eliminar la coma adicional al final
sql_insert = sql_insert.rstrip(", ") + ";"

# Mostrar el SQL generado
print(sql_insert)
