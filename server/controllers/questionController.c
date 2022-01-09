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
#include "questionController.h"

// include auth
#include "../auth/bst.h"
#include "../auth/token.h"

// include models
#include "../models/product.h"
#include "../models/user.h"

extern tree root;
extern token_t tokens[];

void generateQuestion(int socket, tree account) {
  char server_message[BUFF_SIZE] = "\0";
  int no_question = account->data->no_question;
  tree tmp = account;

  if (tmp->data->answer != 0 && strlen(tmp->data->question) > 0) {
    send(socket, tmp->data->question, strlen(tmp->data->question), 0);
  } else if (tmp->data->answer != 0 && strlen(tmp->data->question) == 0) {
    sprintf(server_message, "%d|Wrong user data", ERROR);
    send(socket, server_message, strlen(server_message), 0);
    // reset user data
    tmp->data->answer = 0;
  } else {
    if (0 < no_question && no_question <= MAX_QUESTION) {
      question(no_question, socket, tmp);
    } else if (no_question == MINI_GAME) {
      minigame(socket, tmp);
    } else if (no_question == SPECIAL_QUESTION) {
      printf("special question\n");
      special_question(socket, tmp);
    } else {
      sprintf(server_message, "%d|Wrong user data", ERROR);
      send(socket, server_message, strlen(server_message), 0);
      // reset user data
      tmp->data->answer = 0;
    }
  }
}

void minigame(int socket, tree account) {
  char server_message[BUFF_SIZE] = "\0";
  int no_correct = account->data->no_correct;

  if (no_correct < 0 || no_correct > MAX_QUESTION) {
    send_error(socket, "Wrong user data");
  }

  sprintf(server_message, "%d|%d", QUESTION, no_correct);
  send(socket, server_message, strlen(server_message), 0);
}

void question(int no_question, int socket, tree account) {
  char server_message[BUFF_SIZE] = "\0";
  char product_name[BUFF_SIZE] = "\0";
  char manufacturer[BUFF_SIZE] = "\0";
  double price = 0;
  double totalPrice = 0;
  int quantity = 0;
  char query[BUFF_SIZE] = "\0";
  MYSQL_RES* result;
  MYSQL_ROW row;

  // get random product
  srand(time(NULL));
  int random_product = (TOTAL_PRODUCTS / MAX_QUESTION) * (no_question - 1) +
                       rand() % (TOTAL_PRODUCTS / MAX_QUESTION);
  if (random_product >= TOTAL_PRODUCTS) {
    random_product = TOTAL_PRODUCTS - 1;
  } else if (random_product <= 0) {
    random_product = 1;
  }

  // get information of product
  result = queryProductByID(random_product);
  if (result == NULL) {
    send_error(socket, "Query error");
    return;
  }
  row = mysql_fetch_row(result);
  if (row == NULL) {
    send_error(socket, "Query error");
    return;
  }

  price = atof(row[3]);
  quantity = rand() % 10 + 1;
  totalPrice = price * quantity;
  account->data->answer = totalPrice;
  // convert to question
  sprintf(server_message,
          "%d|What is the price of %d products: %s's %s|%.2f|%.2f", QUESTION,
          quantity, row[2], row[1], totalPrice, totalPrice * 1.05);

  sprintf(account->data->question, "%s", server_message);

  // send to client
  send(socket, server_message, strlen(server_message), 0);
}

void special_question(int socket, tree account) {
  char server_message[BUFF_SIZE] = "\0";
  char product_name[BUFF_SIZE] = "\0";
  char manufacturer[BUFF_SIZE] = "\0";
  double price = 0;
  double total_price = 0;
  int quantity = 0;
  char query[BUFF_SIZE] = "\0";
  MYSQL_RES* result;
  MYSQL_ROW row;

  // get 5 random product, convert to 1 question
  char question[BUFF_SIZE] = "For a list of the following products:\n";
  for (int i = 0; i < PRODUCTS_OF_SPECIAL_QUESTION; i++) {
    char temp[BUFF_SIZE] = "\0";
    int random_product =
        (TOTAL_PRODUCTS / PRODUCTS_OF_SPECIAL_QUESTION) * i +
        rand() % (TOTAL_PRODUCTS / PRODUCTS_OF_SPECIAL_QUESTION);

    result = queryProductByID(random_product);
    if (result == NULL) {
      send_error(socket, "Query error");
      return;
    }
    row = mysql_fetch_row(result);
    if (row == NULL) {
      send_error(socket, "Query error");
      return;
    }

    strcpy(product_name, row[1]);
    strcpy(manufacturer, row[2]);
    price = atof(row[3]);
    quantity = rand() % 10 + 1;
    total_price += price * quantity;
    // convert to question
    sprintf(temp, " - %d %s's %s\n", quantity, manufacturer, product_name);
    strcat(question, temp);
  }
  printf("Answer of final question: %.2f\n", total_price * 1.05);
  account->data->answer = total_price;

  strcat(question, "What is the price of all of these products?");
  // convert to question
  sprintf(server_message, "%d|%s|", QUESTION, question);
  // save question to user
  sprintf(account->data->question, "%s", server_message);

  // send to client
  send(socket, server_message, strlen(server_message), 0);
}

void checkAnswer(int socket, tree account, double answer) {
  char server_message[BUFF_SIZE] = "\0";
  double correct_answer = account->data->answer;
  tree tmp = account;

  if (tmp->data->no_correct < 0 ||
      tmp->data->no_correct > tmp->data->no_question) {
    printf("Error no_correct: %d\n", tmp->data->no_correct);
    tmp->data->no_correct = tmp->data->no_question;
  }

  // MAX_QUESTION of game 1
  if (tmp->data->no_question <= MAX_QUESTION) {
    if (correct_answer - answer < 0.001 && correct_answer - answer > -0.001) {
      tmp->data->no_correct = tmp->data->no_correct + 1;
      sprintf(server_message, "%d|S", ANSWER);
      send(socket, server_message, strlen(server_message), 0);
    } else {
      sprintf(server_message, "%d|F", ANSWER);
      send(socket, server_message, strlen(server_message), 0);
    }
    if (tmp->data->no_question == MAX_QUESTION && tmp->data->no_correct < 5) {
      tmp->data->status = NONE;
    }
    // if not pass minigame then out game
  } else if (tmp->data->no_question == MINI_GAME) {
    if (answer == 1) {
      printf("pass minigame\n");
      tmp->data->no_question = tmp->data->no_question + 1;
    } else {
      printf("out game\n");
      tmp->data->status = NONE;
    }
  } else if (tmp->data->no_question == SPECIAL_QUESTION) {
    printf("Answer of final question: %.2f - %.2f\n", answer, correct_answer);
    double diff = correct_answer - answer;
    double diff_percent = diff / correct_answer;
    if (diff_percent < 0.05 && diff_percent > -0.05) {
      tmp->data->money = answer;
      addMoney(account->data->user_id, answer);
      sprintf(server_message, "%d|S", ANSWER);
      send(socket, server_message, strlen(server_message), 0);
    } else {
      sprintf(server_message, "%d|F", ANSWER);
      send(socket, server_message, strlen(server_message), 0);
    }
    tmp->data->status = NONE;
  }
  // reset question
  tmp->data->answer = 0;
}