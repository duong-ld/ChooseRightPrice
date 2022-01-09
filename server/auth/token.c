#include <stdio.h>
#include <stdlib.h>

#include "../constain.h"
#include "bst.h"
#include "token.h"

int auth(token_t* tokens, int token_id, int user_id) {
  int check = TOKEN_NOT_EXIST;
  if (tokens[token_id].user_id == user_id) {
    check = TOKEN_VALID;
  }

  if (check == TOKEN_NOT_EXIST) {
    for (int i = 0; i < MAX_TOKEN; i++) {
      if (tokens[i].user_id == user_id) {
        check = TOKEN_DISABLED;
        break;
      }
    }
  }

  return check;
}

int get_user_id(token_t* tokens, int token_id) {
  if (tokens == NULL) {
    return -1;
  }
  if (token_id >= MAX_TOKEN) {
    return -1;
  }
  return tokens[token_id].user_id;
}

int set_token_id(token_t* tokens, int user_id) {
  int token_id = -1;
  for (int i = 1; i < MAX_TOKEN; i++) {
    if (tokens[i].user_id == 0) {
      tokens[i].user_id = user_id;
      token_id = i;
    }
  }
  // remove duplicate user_id
  if (token_id > 0) {
    for (int i = 1; i < MAX_TOKEN; i++) {
      if (tokens[i].user_id == user_id && i != token_id) {
        tokens[i].user_id = 0;
      }
    }
  }

  return token_id;
}

void remove_token(token_t* tokens, int token_id) {
  if (tokens == NULL) {
    return;
  }
  if (token_id >= MAX_TOKEN) {
    return;
  }
  tokens[token_id].user_id = 0;
}