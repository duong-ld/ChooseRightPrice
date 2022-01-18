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
#include "resultController.h"

void result(int socket, tree account) {
  char server_message[BUFF_SIZE] = "\0";
  tree tmp = account;
  int no_correct = tmp->data->no_correct;
  int no_question = tmp->data->no_question;
  double money = tmp->data->money;

  if (0 < no_question && no_question <= MAX_QUESTION) {
    sprintf(server_message, "%d|%d|not pass|%.2f|", RESULT, no_correct, money);
  } else if (no_question == MINI_GAME) {
    sprintf(server_message, "%d|%d|not pass|%.2f|", RESULT, no_correct, money);
  } else if (no_question == SPECIAL_QUESTION) {
    sprintf(server_message, "%d|%d|pass|%.2f|", RESULT, no_correct, money);
  } else {
    send_error(socket, "Wrong user data");
  }

  send(socket, server_message, strlen(server_message), 0);
}