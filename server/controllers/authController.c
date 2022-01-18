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
#include "authController.h"

// include auth
#include "../auth/bst.h"
#include "../auth/token.h"

// include models
#include "../models/user.h"

extern tree root;
extern token_t tokens[];

void registerUser(int socket, char* name, char* username, char* password) {
  char server_message[BUFF_SIZE] = "\0";
  MYSQL_RES* result;
  MYSQL_ROW row;
  int token;
  int user_id;

  if (insertUser(name, username, password) == FALSE) {
    sprintf(server_message, "%d|F|User already exists|", REGISTER);
    send(socket, server_message, strlen(server_message), 0);
  }

  // get id of user by username
  result = queryIDByUsername(username);
  if (result == NULL) {
    send_error(socket, "Query error");
    return;
  }
  row = mysql_fetch_row(result);
  if (row == NULL) {
    send_error(socket, "Query error");
    return;
  }
  user_id = atoi(row[0]);

  // create token
  token = set_token_id(tokens, user_id);
  if (token == -1) {
    sprintf(server_message, "%d|F|%s|", REGISTER,
            "Register successfully but cannot create token");
    send(socket, server_message, strlen(server_message), 0);
    return;
  }
  // insert user_id to tree
  root = insertBST(root, user_id);

  sprintf(server_message, "%d|S|%d|%d|", REGISTER, token, user_id);
  send(socket, server_message, sizeof(server_message), 0);
  return;
}

void loginUser(int socket, char* username, char* password) {
  char server_message[BUFF_SIZE] = "\0";
  int token;
  int user_id;

  user_id = authUser(username, password);
  if (user_id == -1) {
    sprintf(server_message, "%d|F|%s|", LOGIN, "Wrong username or password");
    send(socket, server_message, strlen(server_message), 0);
    return;
  }

  // create token
  token = set_token_id(tokens, user_id);
  if (token == -1) {
    sprintf(server_message, "%d|F|%s|", LOGIN,
            "Login successfully but cannot create token");
    send(socket, server_message, strlen(server_message), 0);
    return;
  }
  // insert user_id to tree
  root = insertBST(root, user_id);

  sprintf(server_message, "%d|S|%d|%d|", LOGIN, token, user_id);
  send(socket, server_message, sizeof(server_message), 0);
  return;
}

void logoutUser(int socket, int token_id) {
  char server_message[BUFF_SIZE] = "\0";
  // remove token
  remove_token(tokens, token_id);

  sprintf(server_message, "%d|S|%d|", LOGOUT, token_id);
  send(socket, server_message, sizeof(server_message), 0);
  return;
}