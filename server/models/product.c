#include <mysql/mysql.h>
#include <stdio.h>
#include <stdlib.h>

#include "../constain.h"
#include "mysqlHelper.h"
#include "product.h"

MYSQL_RES* queryProductByID(int id) {
  char query[BUFF_SIZE] = "\0";
  MYSQL_RES* result;
  MYSQL_ROW row;
  MYSQL* con;

  con = initConnection();

  sprintf(query, "SELECT * FROM products LIMIT %d, 1", id);
  if (mysql_query(con, query)) {
    closeConnection(con);
    return NULL;
  }

  result = mysql_store_result(con);

  closeConnection(con);
  return result;
}
