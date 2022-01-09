#ifndef _GAME_CONTROLLER_H_
#define _GAME_CONTROLLER_H_

#include "../auth/bst.h"

void resetGame(int socket, tree account);
void continueGame(int socket, tree account);

#endif  // _GAME_CONTROLLER_H_