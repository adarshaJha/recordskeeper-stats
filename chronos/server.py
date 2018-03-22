#!/usr/bin/python

import MySQLdb

import requests
from json_encoder import json
from requests.auth import HTTPBasicAuth
import sys

network = sys.argv[1]

if network=="main":
  import config_main as cfg
else: 
  import config_test as cfg

def main():
  # Open database connection
  db = MySQLdb.connect(cfg.mysql['host'], cfg.mysql['user'], cfg.mysql['password'], cfg.mysql['db'])
  url = cfg.rpc['url'] 
  headers = { 'content-type': 'application/json'}
  user= cfg.rpc['user'] 
  password = cfg.rpc['password']
  chain_name = str(cfg.rpc['chain_name'])
  payload = [
         {
          "method": "getinfo",
          "params": [],
          "jsonrpc": "2.0",
          "id": "curltext",
          "chain_name": chain_name
          }

  ]
  response = requests.get(url, auth=HTTPBasicAuth(user, password), data = json.dumps(payload), headers=headers)
  response_json = response.json()
  difficulty = response_json[0]['result']['difficulty']
  latest_block = response_json[0]['result']['blocks']

  payload2 = [

          {
          "method": "listblocks",
          "params": [str(latest_block)],
          "jsonrpc": "2.0",
          "id": "curltext",
          "chain_name": chain_name
          }

  ]

  response2 = requests.post(url, auth=HTTPBasicAuth(user, password), data = json.dumps(payload2), headers=headers)
  response_json2 = response2.json()
  latest_block_time = response_json2[0]['result'][0]['time']
  latest_miner = str(response_json2[0]['result'][0]['miner'])
  # prepare a cursor object using cursor() method
  cursor = db.cursor()
  # Prepare SQL query to INSERT a record into the database.
  
  try:
    sql = """INSERT INTO difficulty(VALUE)
             VALUES (%s)""", (difficulty,)
    cursor.execute(*sql)

    
       # Execute the SQL command
    sql2 = """SELECT COUNT(id) FROM block_info;"""
    cursor.execute(sql2)
    row = cursor.fetchone()
    count = int(row[0])

    if count == 0:
      sql3 = """INSERT INTO block_info(best_block, block_time, miner)
             VALUES (%s, %s, %s)""", (latest_block,latest_block_time, latest_miner)
      cursor.execute(*sql3)
      # Commit your changes in the database
      db.commit()
    else:
     sql4 = """SELECT best_block FROM block_info WHERE best_block=(SELECT max(best_block) FROM block_info);"""
     cursor.execute(sql4)
     row = cursor.fetchone()
     last_block = int(row[0])
     block_diff = latest_block-last_block

     if block_diff == 1:
        sql5 = """SELECT block_time FROM block_info WHERE id=(SELECT max(id) FROM block_info);"""
        cursor.execute(sql5)
        row1 = cursor.fetchone()
        last_block_time = int(row1[0])
        time_diff = latest_block_time - last_block_time
        sql6 = """INSERT INTO block_info(best_block, block_time, time_diff, miner)
             VALUES (%s, %s, %s, %s)""", (latest_block,latest_block_time,time_diff, latest_miner)
        cursor.execute(sql6)
        # Commit your changes in the database
        db.commit()
     else:

      for x in range(1,block_diff):
        last_block = last_block + 1
        payload3 = [

            {
            "method": "listblocks",
            "params": [str(last_block)],
            "jsonrpc": "2.0",
            "id": "curltext",
            "chain_name": chain_name
            }

          ]

        response3 = requests.post(url, auth=HTTPBasicAuth(user, password), data = json.dumps(payload3), headers=headers)
        response_json3 = response3.json()
        block_time = response_json3[0]['result'][0]['time']
        miner = str(response_json3[0]['result'][0]['miner'])
        sql7 = """SELECT block_time FROM block_info WHERE id=(SELECT max(id) FROM block_info);"""
        cursor.execute(sql7)
        row1 = cursor.fetchone()
        last_block_time = int(row1[0])
        time_diff = block_time - last_block_time
        sql8 = """INSERT INTO block_info(best_block, block_time, time_diff, miner)
             VALUES (%s, %s, %s, %s)""", (last_block, block_time, time_diff, miner)
        cursor.execute(*sql8)
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

