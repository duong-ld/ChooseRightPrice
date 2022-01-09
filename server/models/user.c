#include <mysql/mysql.h>
#include <stdio.h>
#include <stdlib.h>

#include "../constain.h"
#include "mysqlHelper.h"
#include "user.h"

MYSQL_RES* queryUserByID(int id) {
  char query[BUFF_SIZE];
  MYSQL_RES* result;
  MYSQL* con;

  con = initConnection();

  sprintf(query, "SELECT * FROM users LIMIT %d, 1", id);
  if (mysql_query(con, query)) {
    closeConnection(con);
    return NULL;
  }

  result = mysql_store_result(con);
  closeConnection(con);
  return result;
}

MYSQL_RES* queryTop10ByMoney() {
  char query[BUFF_SIZE] = "\0";
  MYSQL_RES* result;
  MYSQL* con;

  con = initConnection();

  sprintf(query, "SELECT name, money FROM users ORDER BY money DESC LIMIT 10");
  if (mysql_query(con, query)) {
    closeConnection(con);
    return NULL;
  }

  result = mysql_store_result(con);
  closeConnection(con);
  return result;
}

MYSQL_RES* queryRankByID(int id) {
  char query[BUFF_SIZE] = "\0";
  MYSQL_RES* result;
  MYSQL* con;

  con = initConnection();

  sprintf(query,
          "SELECT name, money, (SELECT COUNT(*) FROM users WHERE "
          "money>x.money) AS rank_lower, (SELECT COUNT(*) FROM users WHERE "
          "money<x.money) AS rank_upper, (SELECT COUNT(*) - 1 FROM users WHERE "
          "money=x.money) AS rank_equal FROM `users` x WHERE x.id = %d",
          id);

  if (mysql_query(con, query)) {
    closeConnection(con);
    return NULL;
  }

  result = mysql_store_result(con);
  closeConnection(con);
  return result;
}

Boolean addMoney(int id, double money) {
  char query[BUFF_SIZE] = "\0";
  MYSQL* con;

  con = initConnection();

  sprintf(query, "UPDATE users SET money = money + %f WHERE id = %d", money,
          id);
  if (mysql_query(con, query)) {
    closeConnection(con);
    return FALSE;
  }

  closeConnection(con);
  return TRUE;
}

Boolean insertUser(char* name, char* username, char* password) {
  char query[BUFF_SIZE] = "\0";
  MYSQL* con;

  con = initConnection();
  sprintf(query,
          "INSERT INTO users (name, username, password) VALUES ('%s', '%s', "
          "'%s')",
          name, username, password);

  if (mysql_query(con, query)) {
    closeConnection(con);
    return FALSE;
  }

  closeConnection(con);
  return TRUE;
}

MYSQL_RES* queryIDByUsername(char* username) {
  char query[BUFF_SIZE] = "\0";
  MYSQL_RES* result;
  MYSQL* con;

  con = initConnection();

  sprintf(query, "SELECT id FROM users WHERE username = '%s'", username);
  if (mysql_query(con, query)) {
    closeConnection(con);
    return NULL;
  }
  result = mysql_store_result(con);
  closeConnection(con);
  return result;
}

int authUser(char* username, char* password) {
  char query[BUFF_SIZE] = "\0";
  MYSQL_RES* result;
  MYSQL_ROW row;
  MYSQL* con;

  con = initConnection();

  sprintf(query, "SELECT * from users where username='%s' and password='%s'",
          username, password);
  if (mysql_query(con, query)) {
    closeConnection(con);
    return -1;
  }

  result = mysql_store_result(con);
  if (mysql_num_rows(result) == 0) {
    closeConnection(con);
    return -1;
  }

  // get id of user
  row = mysql_fetch_row(result);
  if (row == NULL) {
    closeConnection(con);
    return -1;
  }
  int user_id = atoi(row[0]);

  closeConnection(con);
  return user_id;
}