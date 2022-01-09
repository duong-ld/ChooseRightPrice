#ifndef _MYSQL_HELPER_H_
#define _MYSQL_HELPER_H_

#include <mysql/mysql.h>
#include <stdio.h>

MYSQL* initConnection();

void closeConnection(MYSQL* con);

#endif  // _MYSQL_HELPER_H_