#ifndef _QUESTION_H_
#define _QUESTION_H_

#include "../auth/bst.h"

// question
void generateQuestion(int socket, tree account);

/**
 * @brief get information of product from database convert to question, send
 * to client
 * @param message message from client
 * @param socket socket of client
 * @return void
 * @author Luong Duong
 *
 */
void question(int no_question, int socket, tree account);
/**
 * @brief get information of list products from database convert to
 * question, send to client
 * @param message message from client
 * @param socket socket of client
 * @return void
 * @author Luong Duong
 *
 */
void special_question(int socket, tree account);

// send no_correct to client
void minigame(int socket, tree account);
// answer
void checkAnswer(int socket, tree account, double answer);

#endif  // _QUESTION_H_