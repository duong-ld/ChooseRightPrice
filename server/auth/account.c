#include <stdio.h>
#include <stdlib.h>

#include "../constain.h"
#include "account.h"

Account createAccount(int token) {
  Account tmp = (Account)malloc(sizeof(Account));
  tmp->user_id = token;
  tmp->answer = 0;
  tmp->no_question = 0;
  tmp->no_correct = 0;
  tmp->money = 0;
  tmp->status = NONE;
  return tmp;
}

void destroyAccount(Account account) {
  free(account);
}