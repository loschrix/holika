import json
import mysql.connector


with open('data.json', 'r', encoding="utf8") as file:
    data = json.load(file)


db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="holika-holika"
)

cursor = db.cursor()


for cosmetic in data["cosmetics"]:
    sql = "INSERT INTO cosmetics (name, id_type, img, price, date, shortDescription, description, ingredients, quantity) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
    values = (cosmetic["name"], ','.join(map(str, cosmetic["id_type"])), cosmetic["img"], cosmetic["price"], cosmetic["date"], cosmetic["shortDescription"], cosmetic["description"], cosmetic["ingredients"], cosmetic["quantity"])
    cursor.execute(sql, values)


db.commit()


db.close()