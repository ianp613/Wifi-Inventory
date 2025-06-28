import mysql.connector

conn = mysql.connector.connect(host="localhost", user="root", database="wifi_inventory")
cursor = conn.cursor()

description= "Joseph PC"

query = f"SELECT ip FROM ip_address WHERE hostname LIKE '%{description}%';"
cursor.execute(query)
result = cursor.fetchall()

print(result)