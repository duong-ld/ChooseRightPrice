#ifndef _TOKEN_H_
#define _TOKEN_H_

typedef struct token_t {
  int user_id;
} token_t;

int auth(token_t* tokens, int token_id, int user_id);
int get_user_id(token_t* tokens, int token_id);
void remove_token(token_t* tokens, int token_id);
int set_token_id(token_t* tokens, int user_id);

#endif  // _TOKEN_H_