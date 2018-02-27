#!/usr/bin/python

import MySQLdb

import requests
from json_encoder import json
import sys

network = sys.argv[1]

if network=="main":
  import config_main as cfg
else: 
  import config_test as cfg

def main():
  # Open database connection
  db = MySQLdb.connect(cfg.mysql['host'], cfg.mysql['user'], cfg.mysql['password'], cfg.mysql['db'])
  # prepare a cursor object using cursor() method
  cursor = db.cursor()
  # SQL query to SELECT records from the database.
  sql = """SELECT AVG(value) FROM difficulty WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY id ASC;"""
  sql1 = """SELECT AVG(time_diff) FROM block_info WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY id ASC;"""

  try:
  	 # Execute the SQL command
     cursor.execute(sql)
     # Fetch the data from database
     row = cursor.fetchone()
     # convert tuple into float
     difficulty = float(row[0])
     # Execute the SQL command
     cursor.execute(sql1)
     # Fetch the data from database
     row1 = cursor.fetchone()
     # convert tuple into int
     time_diff = int(row1[0])
     hash_rate = difficulty/time_diff
     # SQL query to insert records to the database
     sql2 = """INSERT INTO chart_values(difficulty, hash_rate)
           VALUES ("%s", "%s")""", (difficulty, hash_rate)
     # Execute the SQL command
     cursor.execute(*sql2)
     # Commit your changes in the database
     db.commit()
     # disconnect from server
     db.close()
  except:
     # Rollback in case there is any error
     db.rollback()
     # disconnect from server
     db.close()

if __name__ == "__main__":
    main()
