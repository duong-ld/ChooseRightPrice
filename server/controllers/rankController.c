#include <mysql/mysql.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/ioctl.h>
#include <sys/select.h>
#include <sys/socket.h>
#include <sys/time.h>

#include "../constain.h"
#include "../support/error.h"
#include "rankController.h"

// include auth
#include "../auth/bst.h"
#include "../auth/token.h"

// include models
#include "../models/user.h"

void rank(int socket, tree account) {
  MYSQL_RES* result;
  MYSQL_ROW row;
  char server_message[BUFF_SIZE] = "\0";
  int key = account->data->user_id;

  // query get name and money of 10 users have highest money
  result = queryTop10ByMoney();
  if (result == NULL) {
    send_error(socket, "Query error");
    return;
  }

  // get number of rows
  int num_rows = mysql_num_rows(result);
  sprintf(server_message, "%d|%d|", RANK, num_rows);

  char temp[BUFF_SIZE] = "\0";
  while ((row = mysql_fetch_row(result))) {
    sprintf(temp, "%s|%s|", row[0], row[1]);
    strcat(server_message, temp);
    memset(temp, '\0', BUFF_SIZE);
  }
  send(socket, server_message, strlen(server_message), 0);

  // query get rank of user by id
  result = queryRankByID(key);
  if (result == NULL) {
    send_error(socket, "Query error");
    return;
  }

  row = mysql_fetch_row(result);
  if (row == NULL) {
    send_error(socket, "Query error");
    return;
  }

  sprintf(server_message, "%d|%s|%s|%s|%s|%s", RANK, row[0], row[1], row[2],
          row[3], row[4]);
  send(socket, server_message, strlen(server_message), 0);
}