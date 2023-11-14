import json

# Cargar el JSON desde el archivo
with open("python\datos_compra.json", "r") as json_file:
    datos_compra_json = json.load(json_file)

# Crear SQL para insertar tamaños
sql_insert_tamanos = "INSERT INTO tamanos (nombre) VALUES "
values_tamanos = set()

for producto in datos_compra_json:
    tamano = producto['PRESENTACION']
    
    # Ignorar tamaños nulos y evitar duplicados
    if tamano and tamano != "nan" and tamano not in values_tamanos:
        values_tamanos.add(tamano)
        sql_insert_tamanos += f"('{tamano}'), "

# Eliminar la coma adicional al final
sql_insert_tamanos = sql_insert_tamanos.rstrip(", ") + ";"

# Mostrar el SQL generado
print(sql_insert_tamanos)
