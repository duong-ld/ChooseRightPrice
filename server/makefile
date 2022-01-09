OBJS += select_server.o

# models
OBJS += user.o product.o mysqlHelper.o

# controllers
OBJS += authController.o gameController.o questionController.o rankController.o resultController.o

# auth
OBJS += account.o bst.o token.o

# routes
OBJS += api.o

# support
OBJS += error.o encrypt.o

LIBS = `pkg-config --libs mysqlclient`

all: server

server: $(OBJS)
	gcc -o server $(OBJS) $(LIBS)

select_server.o: select_server.c
	gcc -c select_server.c

api.o: routes/api.c
	gcc -c routes/api.c

error.o: support/error.c
	gcc -c support/error.c

encrypt.o: support/encrypt.c
	gcc -c support/encrypt.c

user.o: models/user.c
	gcc -c models/user.c

product.o: models/product.c
	gcc -c models/product.c

mysqlHelper.o: models/mysqlHelper.c
	gcc -c models/mysqlHelper.c

authController.o: controllers/authController.c
	gcc -c controllers/authController.c

gameController.o: controllers/gameController.c
	gcc -c controllers/gameController.c

questionController.o: controllers/questionController.c
	gcc -c controllers/questionController.c

rankController.o: controllers/rankController.c
	gcc -c controllers/rankController.c

resultController.o: controllers/resultController.c
	gcc -c controllers/resultController.c

account.o: auth/account.c
	gcc -c auth/account.c

bst.o: auth/bst.c
	gcc -c auth/bst.c

token.o: auth/token.c
	gcc -c auth/token.c

clean:
	rm -f server
	rm -f select_server.o
	rm -f api.o
	rm -f error.o
	rm -f encrypt.o
	rm -f user.o
	rm -f product.o
	rm -f mysqlHelper.o
	rm -f authController.o
	rm -f gameController.o
	rm -f questionController.o
	rm -f rankController.o
	rm -f resultController.o
	rm -f account.o
	rm -f bst.o
	rm -f token.o

	