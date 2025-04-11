# Biên dịch một chương trình C đơn giản
all: main

main: main.c
	gcc -o main main.c

clean:
	rm -f main