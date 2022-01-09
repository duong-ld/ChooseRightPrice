#include <mysql/mysql.h>
#include <stdio.h>

MYSQL* initConnection() {
  MYSQL* con = mysql_init(NULL);
  if (con == NULL) {
    fprintf(stderr, "%s\n", mysql_error(con));
    exit(1);
  }

  if (mysql_real_connect(con, "localhost", "root", "", "testdb", 0, NULL, 0) ==
      NULL) {
    fprintf(stderr, "%s\n", mysql_error(con));
    mysql_close(con);
    exit(1);
  }
  return con;
}

void closeConnection(MYSQL* con) {
  mysql_close(con);
}