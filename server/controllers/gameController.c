#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/ioctl.h>
#include <sys/select.h>
#include <sys/socket.h>
#include <sys/time.h>

#include "../constain.h"
#include "../support/error.h"

// include auth
#include "../auth/bst.h"
#include "../auth/token.h"

void resetGame(int socket, tree account) {
  char server_message[BUFF_SIZE] = "\0";
  tree tmp = account;

  tmp->data->answer = 0;
  tmp->data->no_question = 0;
  tmp->data->no_correct = 0;
  tmp->data->money = 0;
  tmp->data->status = IN_GAME;

  sprintf(server_message, "%d|S|", RESET);

  send(socket, server_message, strlen(server_message), 0);
}

void continueGame(int socket, tree account) {
  char server_message[BUFF_SIZE] = "\0";
  tree tmp = account;

  if (tmp->data->no_question > SPECIAL_QUESTION ||
      tmp->data->no_question <= 0 || tmp->data->status == NONE) {
    tmp->data->no_question = 1;
    tmp->data->no_correct = 0;
    tmp->data->money = 0;
  }

  tmp->data->status = IN_GAME;

  sprintf(server_message, "%d|%d|%d|", CONTINUER, tmp->data->no_question,
          tmp->data->no_correct);

  send(socket, server_message, strlen(server_message), 0);
}
