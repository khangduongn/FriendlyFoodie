#import modules

#delete the recipes.sqlite first before running this file

import csv
import sqlite3
 

#connect to database
connection = sqlite3.connect('./database/recipes.sqlite')
 
#create curser to execute SQL queries
cursor = connection.cursor()
 
#sql query to create a recipes table
create_table = '''CREATE TABLE IF NOT EXISTS recipes (
    recipeId INTEGER PRIMARY KEY,
    recipeName VARCHAR(255),	
    recipeType VARCHAR(255),	
    calories DECIMAL(10,5),	
    prepTime VARCHAR(255),	
    ingredients VARCHAR(255),	
    dietaryRestrictions VARCHAR(255),
    directions VARCHAR(255))'''
 
#execute the query
cursor.execute(create_table)
 

#open the recipes excel file
file = open('Recipes.csv', encoding = "ISO-8859-1")
 
#read the contents
contents = csv.reader(file, skipinitialspace = True)
 
#skip header
next(contents, None)


#sql query to insert data into sql table
insert_records = "INSERT INTO recipes (recipeName, recipeType, calories, prepTime, ingredients, dietaryRestrictions, directions) VALUES(?, ?, ?, ?, ?, ?, ?)"
 
#execute query with the contents of the csv file
cursor.executemany(insert_records, contents)
 

#commit the changes
connection.commit()
 
#close database connection
connection.close()