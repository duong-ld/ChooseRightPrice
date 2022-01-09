#ifndef _ACCOUNT_H_
#define _ACCOUNT_H_

struct AccountData {
  int user_id;
  char question[BUFF_SIZE];
  double answer;
  int no_question;
  int no_correct;
  double money;
  int status;
};

typedef struct AccountData* Account;

Account createAccount(int token);
void destroyAccount(Account account);

#endif  // _ACCOUNT_H_