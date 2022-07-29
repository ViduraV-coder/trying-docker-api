from flask import Flask, request, jsonify
from flask_mysqldb import MySQL
from flask_sqlalchemy import SQLAlchemy
from flask_marshmallow import Marshmallow
import os

# Init app
app = Flask(__name__)
basedir = os.getcwd()

# Database
app.config['SQLALCHEMY_DATABASE_URI'] = "mysql://root:12345@db:3306/mydb"
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

# Init Database
db = SQLAlchemy(app)

# Init Marshmallow
ma = Marshmallow(app)


# Item Class/Model
class Item(db.Model):
    __tablename__ = "item"
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), unique=True)
    price = db.Column(db.Integer)
    quantity = db.Column(db.Integer)

    def __init__(self, name, price, quantity):
        self.name = name
        self.price = price
        self.quantity = quantity

db.create_all()

# Item Schema
class ItemSchema(ma.Schema):
    class Meta:
        fields = ('id', 'name', 'price', 'quantity')


# Init Schema
item_schema = ItemSchema()
items_schema = ItemSchema(many=True)



# Create an Item
@app.route('/items/create', methods=['POST'])
def add_item():

    name = request.json['name']
    price = request.json['price']
    quantity = request.json['quantity']
    
    new_item = Item(name, price, quantity)
    
    db.session.add(new_item)
    db.session.commit()
    
    return item_schema.jsonify(new_item)


# Get all Items
@app.route('/items/show', methods=['GET'])
def get_items():

    all_items = Item.query.all()
    result = items_schema.dump(all_items)
    return jsonify(result)


# Get an Item
@app.route('/items/show/<id>', methods=['GET'])
def get_item(id):

    item = Item.query.get(id)
    return item_schema.jsonify(item)


# Update an Item
@app.route('/items/change/<id>', methods=['PUT'])
def update_item(id):

    item = Item.query.get(id)
    name = request.json['name']
    price = request.json['price']
    quantity = request.json['quantity']
    item.name = name
    item.price = price
    item.quantity = quantity
    db.session.commit()
    return item_schema.jsonify(item)

# Delete an Item
@app.route('/items/discard/<id>', methods=['DELETE'])
def delete_item(id):

    item = Item.query.get(id)
    db.session.delete(item)
    db.session.commit()
    return item_schema.jsonify(item)
    
# Run Server
if __name__ == '__main__':
    app.run(debug=True)
