#include <mysql/mysql.h>
#include <netinet/in.h>
#include <pthread.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <sys/types.h>
#include <unistd.h>

#include "../constain.h"
#include "../support/encrypt.h"
#include "../support/error.h"
#include "api.h"

// include models
#include "../models/product.h"
#include "../models/user.h"

// include controllers
#include "../controllers/authController.h"
#include "../controllers/gameController.h"
#include "../controllers/questionController.h"
#include "../controllers/rankController.h"
#include "../controllers/resultController.h"

// include auth
#include "../auth/bst.h"
#include "../auth/token.h"

extern tree root;
extern token_t tokens[];

void handle_message(char* message, int socket) {
  // variables for login, register
  char username[BUFF_SIZE];
  char password[BUFF_SIZE];
  char name[BUFF_SIZE];

  // variables for private routes
  int token_id = 0;
  int user_id = 0;
  tree account = NULL;

  // variables for question and answer
  double answer = 0;
  int no_question = 0;

  // variables for split message
  char* temp;

  temp = strtok(message, "|");
  if (temp == NULL) {
    send_error(socket, "Invalid message");
    return;
  }
  // get type of message
  int type = atoi(temp);

  /**
   * @brief Public routes
   * user message for theses routes doesn't need token
   */
  if (type == LOGIN || type == REGISTER) {
    switch (type) {
      /**
       * @brief Login route for user
       * user message: LOGIN|username|password
       */
      case LOGIN:
        // get username and password
        temp = strtok(NULL, "|");
        if (temp == NULL) {
          send_error(socket, "Invalid message");
          return;
        }
        strcpy(username, temp);
        temp = strtok(NULL, "|");
        if (temp == NULL) {
          send_error(socket, "Invalid message");
          return;
        }
        strcpy(password, temp);
        encryptPassword(password);

        loginUser(socket, username, password);
        break;
      /**
       * @brief Register route for user
       * user message: REGISTER|name|username|password
       */
      case REGISTER:
        // get name, username and password
        temp = strtok(NULL, "|");
        if (temp == NULL) {
          send_error(socket, "Invalid message");
          return;
        }
        strcpy(name, temp);
        temp = strtok(NULL, "|");
        if (temp == NULL) {
          send_error(socket, "Invalid message");
          return;
        }
        strcpy(username, temp);
        temp = strtok(NULL, "|");
        if (temp == NULL) {
          send_error(socket, "Invalid message");
          return;
        }
        strcpy(password, temp);
        encryptPassword(password);
        registerUser(socket, name, username, password);
        break;
      default:
        break;
    }
  }
  // end public routes

  /**
   * @brief Private routes
   * Us
   */
  else {
    // get token id
    temp = strtok(NULL, "|");
    if (temp == NULL) {
      send_error(socket, "Invalid message");
      return;
    }
    token_id = atoi(temp);

    // get user id
    temp = strtok(NULL, "|");
    if (temp == NULL) {
      send_error(socket, "Invalid message");
      return;
    }
    user_id = atoi(temp);

    // validate token
    int check = auth(tokens, token_id, user_id);
    if (check == TOKEN_DISABLED) {
      send_error(socket, "Account is signed in on another device.");
      return;
    }
    if (check == TOKEN_NOT_EXIST) {
      printf("Token not exist\n");
      send_error(socket, "User is not logged in.");
      return;
    }

    // search user_id in tree
    tree account = searchBST(root, user_id);
    if (account == NULL) {
      send_error(socket, "Invalid user");
      return;
    }

    switch (type) {
      case QUESTION:
        temp = strtok(NULL, "|");
        if (temp == NULL) {
          send_error(socket, "Invalid message");
          return;
        }
        no_question = atoi(temp);
        if (no_question < 0 || no_question > SPECIAL_QUESTION) {
          send_error(socket, "Invalid question");
          return;
        }
        if (account->data->no_question > SPECIAL_QUESTION ||
            account->data->no_question < 0) {
          printf("\nno_question_error: %d\n", account->data->no_question);
        }
        if (account->data->status == NONE) {
          send_error(socket, "User is not playing");
          return;
        }

        account->data->no_question = no_question;
        printf("no_question: %d\n", no_question);
        generateQuestion(socket, account);
        break;
      case ANSWER:
        temp = strtok(NULL, "|");
        if (temp == NULL) {
          send_error(socket, "Invalid message");
          return;
        }
        no_question = atoi(temp);

        if (no_question < 0 || no_question > SPECIAL_QUESTION) {
          send_error(socket, "Invalid question");
          return;
        }

        if (no_question != account->data->no_question) {
          if (account->data->no_question < 0 ||
              account->data->no_question > SPECIAL_QUESTION) {
            printf("\nno_question_error: %d\n", account->data->no_question);
            account->data->no_question = no_question;
          } else {
            send_error(socket, "Invalid question");
            return;
          }
        }

        if (account->data->status == NONE) {
          send_error(socket, "User is not playing");
          return;
        }

        temp = strtok(NULL, "|");
        if (temp == NULL) {
          send_error(socket, "Invalid message");
          return;
        }
        double answer = atof(temp);

        checkAnswer(socket, account, answer);
        break;
      case RESULT:
        result(socket, account);
        break;
      case RANK:
        rank(socket, account);
        break;
      case RESET:
        resetGame(socket, account);
        break;
      case CONTINUER:
        continueGame(socket, account);
        break;
      case LOGOUT:
        logoutUser(socket, token_id);
        break;
      default:
        break;
    }
  }

  printf("Closed\n");
}
