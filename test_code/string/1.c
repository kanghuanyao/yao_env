#include <stdio.h>
#include <string.h>



int main()
{
	char input = 'c';
	unsigned int i = 0;
	char output[20] = {0};
	char check[20] = {0};
	char b[3] ;
	
	static char hex_list[16] = {'0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f'};
	
	
	printf ("input=0x%x\n", (unsigned char) input);
	
	b[0] = hex_list[(input>>4)];
	b[1] = hex_list[(input&15)];
	b[2] = '\0';
	
	
	printf ("b[0]=0x%x\n", b[0]);
	printf ("b[1]=0x%x\n", b[1]);
	printf ("b=%s\n", b);
	
	return 0;
}
