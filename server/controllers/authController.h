#ifndef _AUTH_CONTROLLER_H_
#define _AUTH_CONTROLLER_H_

void registerUser(int socket, char* name, char* username, char* password);
void loginUser(int socket, char* username, char* password);
void logoutUser(int socket, int token_id);

#endif  // _AUTH_CONTROLLER_H_