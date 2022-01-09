#ifndef _USER_H
#define _USER_H

MYSQL_RES* queryUserByID(int id);
MYSQL_RES* queryIDByUsername(char* username);
MYSQL_RES* queryTop10ByMoney();
MYSQL_RES* queryRankByID(int id);
Boolean addMoney(int id, double money);
Boolean insertUser(char* name, char* username, char* password);
int authUser(char* username, char* password);

#endif  // _USER_H