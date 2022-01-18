#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/ioctl.h>
#include <sys/select.h>
#include <sys/socket.h>
#include <sys/time.h>

#include "../constain.h"
#include "error.h"

void send_error(int sockfd, char* msg) {
  char server_message[BUFF_SIZE];
  sprintf(server_message, "%d|%s|", ERROR, msg);
  send(sockfd, server_message, strlen(server_message), 0);
}