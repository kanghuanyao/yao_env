#include <stdio.h>
#include <string.h>

static unsigned int hexstr2array (char *input, unsigned char output[])
{
	unsigned int length = strlen(input);
	unsigned int i=0;
	char tmp[3];

	if ((length % 2) != 0)
	{
		fprintf (stderr, "[ERROR] %s:%u: input length error:%u\n", __FILE__,__LINE__,length);
		return 0;
	}

	for (i=0;i<length;i++)
	{
		char c = input[i];
		if (c < '0' ||
			((c > '9') && (c < 'A')) ||
			((c > 'F') && (c < 'a')) ||
			(c > 'f'))
			{
			fprintf (stderr, "[ERROR] %s:%u: input string error: %s\n", __FILE__,__LINE__, input);
			return 0;
			}
	}

	for (i=0;i<length;i+=2)
	{
		tmp[0] = input[i];
		tmp[1] = input[i+1];
		tmp[2] = '\0';
		output[i/2] = strtol (tmp, NULL, 16);
	}

	return 1;
}

static void print_bytes(char *str,unsigned char *input, int len)
{
	int i=0;
	printf ("%s\n",str);
	for (i=0;i<len;i++)
	{
//		if (i%2 == 0) printf (" ");
		printf ("%02x",input[i]);
	}
	printf ("\n");
	return ;
}

int main()
{
	char *str = "8764b655cd3571912defde2b635f0792ee55ad55f86ce3bd14635402efd9cb59ee55ad55f86ce3bd14635402efd9cb59ee55ad55f86ce3bd14635402efd9cb59";
	unsigned char str_byte[64] = {0};
	
	unsigned char str_strncpy[64] = {0};
	unsigned char str_memcpy[64] = {0};
	
	hexstr2array(str, str_byte);
	
	print_bytes("str_byte:", str_byte, 64);
	
	strncpy(str_strncpy, str_byte, 64);
	
	memcpy(str_memcpy, str_byte, 64);
	
	print_bytes("str_strncpy:", str_strncpy, 64);
	print_bytes("str_memcpy:", str_memcpy, 64);
	
	printf ("compare result: %d\n", memcmp(str_strncpy, str_memcpy,64));
}