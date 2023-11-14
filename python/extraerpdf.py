import tabula
import pandas as pd
import json
from unidecode import unidecode

# Ruta al archivo PDF
pdf_path_compra = "python/Lista_Precios_Min_2023-1.pdf"
pdf_path_venta = "python/Productos de Limpieza 2023 - 35.pdf"

# Extraer datos de la tabla
def extraer_datos(pdf_path):
    # Lee el PDF y devuelve una lista de DataFrames
    df_list = tabula.read_pdf(pdf_path, pages='all')
    # Concatena los DataFrames en uno solo
    df = pd.concat(df_list, ignore_index=True)
    return df

# Extraer datos de precios de compra
datos_compra = extraer_datos(pdf_path_compra)

# Ajusta las columnas relevantes según tus datos reales
columnas_relevantes = ['DESCRIPCIÓN PRODUCTO', 'UNIDAD EMPAQUE', 'PRESENTACION', 'P. VENTA ANTES DE IVA']

# Asegúrate de que las columnas existan antes de intentar seleccionarlas
if all(col in datos_compra.columns for col in columnas_relevantes):
    # Seleccionar columnas relevantes y renombrarlas
    datos_compra = datos_compra[columnas_relevantes].rename(columns={'DESCRIPCIÓN PRODUCTO': 'nombre', 'PRESENTACION': 'tamano', 'P. VENTA ANTES DE IVA': 'precio_compra'})
else:
    print("¡Alguna columna no existe en datos_compra!")

# Convertir DataFrame a formato JSON con caracteres especiales eliminados
datos_compra_json = datos_compra.applymap(lambda x: unidecode(str(x)) if x else x).to_json(orient='records', indent=2)  # Sin 'sort_keys'

# Ordenar las claves del JSON
datos_compra_json = json.dumps(json.loads(datos_compra_json), indent=2, sort_keys=True)

# Guardar el JSON en un archivo
with open("datos_compra.json", "w") as json_file:
    json_file.write(datos_compra_json)

print("Datos de compra guardados en 'datos_compra.json'")
