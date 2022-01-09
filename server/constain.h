#ifndef _CONSTAIN_H_
#define _CONSTAIN_H_

#define PORT 9999
#define BACKLOG 20
#define BUFF_SIZE 1024
#define TOKEN_SIZE 20
#define TOTAL_PRODUCTS 4398
#define MAX_QUESTION 9
#define MAX_TOKEN 200
#define PRODUCTS_OF_SPECIAL_QUESTION 5
#define TRUE 1
#define FALSE 0

typedef int Boolean;

enum {
  // server message status
  SUCCESS,
  FAILURE,
  // state of client
  NONE,
  IN_GAME,
  IN_VIEW_RESULT,
  // state of token
  TOKEN_NOT_EXIST,
  TOKEN_DISABLED,
  TOKEN_VALID,
  // state of question
  MINI_GAME = 10,
  SPECIAL_QUESTION = 11,
  // message type and also user choose function
  LOGIN = 1,
  REGISTER = 2,
  LOGOUT = 3,
  RESET = 4,
  QUESTION = 5,
  ANSWER = 6,
  RANK = 7,
  RESULT = 8,
  CONTINUER = 9,
  ERROR = 0,
};

#endif  // _CONSTAIN_H_
