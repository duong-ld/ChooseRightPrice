#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include "../constain.h"
#include "account.h"
#include "bst.h"

//
tree createNullTree() {
  return (tree)NULL;
}
//
tree createLeaf(int user_id) {
  tree tmp = (tree)malloc(sizeof(struct TreeNode));
  tmp->data = createAccount(user_id);
  tmp->left = (tree)NULL;
  tmp->right = (tree)NULL;
  return tmp;
}
//
int isNullTree(tree t) {
  return (t == NULL);
}
//
tree insertBST(tree t, int user_id) {
  if (isNullTree(t))
    return createLeaf(user_id);

  if (t->data->user_id == user_id)
    return t;
  else if (t->data->user_id > user_id) {
    t->left = insertBST(t->left, user_id);
    return t;
  } else {
    t->right = insertBST(t->right, user_id);
    return t;
  }
}

tree left_most(tree t) {
  if (t == NULL)
    return t;
  else {
    while (t->left != NULL) {
      t = t->left;
    }
  }
  return t;
}
//
tree removeBST(tree root, int user_id) {
  if (isNullTree(root))
    return root;

  if (searchBST(root, user_id) != NULL) {
    if (root->data->user_id == user_id) {
      //
      if (root->left == NULL) {
        tree tmp = root->right;
        destroyAccount(root->data);
        free(root);
        return tmp;
      }
      //
      if (root->right == NULL) {
        tree tmp = root->left;
        destroyAccount(root->data);
        free(root);
        return tmp;
      }
      //
      root->data = left_most(root->right)->data;
      root->right = removeBST(root->right, root->data->user_id);
      return root;
    } else if (root->data->user_id > user_id) {
      root->left = removeBST(root->left, user_id);
    } else {
      root->right = removeBST(root->right, user_id);
    }
  } else {
    printf("\nNot found\n");
  }

  return root;
}

tree searchBST(tree t, int user_id) {
  if (isNullTree(t))
    return NULL;

  if (t->data->user_id == user_id)
    return t;
  else if (t->data->user_id < user_id)
    return searchBST(t->right, user_id);
  else {
    return searchBST(t->left, user_id);
  }
}

void preorderPrint(tree t) {
  if (t != NULL) {
    printf("%d, ", t->data->user_id);
    preorderPrint(t->left);
    preorderPrint(t->right);
  }
}

void inorderPrint(tree t) {
  if (t != NULL) {
    inorderPrint(t->left);
    printf("%d - %f\n, ", t->data->user_id, t->data->answer);
    inorderPrint(t->right);
  }
}

void postorderPrint(tree t) {
  if (t != NULL) {
    postorderPrint(t->left);
    postorderPrint(t->right);
    printf("%d, ", t->data->user_id);
  }
}

void freeTree(tree t) {
  if (t != NULL) {
    freeTree(t->left);
    freeTree(t->right);
    destroyAccount(t->data);
    free(t);
  }
}