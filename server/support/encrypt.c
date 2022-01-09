#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include "encrypt.h"

void encryptPassword(char* password) {
  int encrypt = 0;
  for (int i = 0; i < strlen(password); i++) {
    if ((password[i] - i >= '0' && password[i] - i <= '9') ||
        (password[i] - i >= 'a' && password[i] - i <= 'z') ||
        (password[i] - i >= 'A' && password[i] - i <= 'Z'))
      password[i] = password[i] - i;
  }
}