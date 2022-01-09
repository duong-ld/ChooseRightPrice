#ifndef _BST_H_
#define _BST_H_

#include "account.h"

typedef Account element_t;

struct TreeNode {
  element_t data;
  struct TreeNode* left;
  struct TreeNode* right;
};

typedef struct TreeNode* tree;

tree createNullTree();

int isNullTree(tree t);

tree createLeaf(int token);

tree insertBST(tree t, int token);

tree removeBST(tree t, int token);

tree searchBST(tree t, int token);

void inorderPrint(tree t);

void preorderPrint(tree t);

void postorderPrint(tree t);

void freeTree(tree t);

#endif