# Write-ups Engenharia Reversa/Pwning
## Challs com Writeup
1. [Weird Comparison](#weirdcomparison)
2. [Não chore](#naochore)
3. [Pode chorar](#podechorar)
4. [So Many Words](#somanywords)
5. [Crackme](#crackme)
6. [Code](#code)
7. [Você sabe crackear MD5?](#sabemd5)
8. [HackerTest](#hackertest)
9. [Ghidra Challenge](#guidrachall)
10. [JFCH](#jfch)
11. [Entenda-me](#entendame)


## Weird Comparison <a name="weirdcomparison"></a>
```
Ifs nem sempre são tão seguros assim, é possível manipular o resultado deles usando o GDB?
```

Como o enunciado diz, a intenção do desafio é manipular o resultado de um `if`.

Ao rodar o programa, temos a seguinte saída:
```
Você falhou! A variável é 0xdeadbeef
```

Olhando o disassembly da função main no gdb, temos:

```
pwndbg> disas main
Dump of assembler code for function main:
   0x0000000000001159 <+0>:     push   rbp
   0x000000000000115a <+1>:     mov    rbp,rsp
   0x000000000000115d <+4>:     sub    rsp,0x30
   0x0000000000001161 <+8>:     mov    rax,QWORD PTR fs:0x28
   0x000000000000116a <+17>:    mov    QWORD PTR [rbp-0x8],rax
   0x000000000000116e <+21>:    xor    eax,eax
   0x0000000000001170 <+23>:    mov    DWORD PTR [rbp-0x28],0xdeadbeef
   0x0000000000001177 <+30>:    mov    eax,DWORD PTR [rbp-0x28]
   0x000000000000117a <+33>:    cmp    eax,0xcafebabe
   0x000000000000117f <+38>:    jne    0x11de <main+133>
   ...
```

Encontramos o `0xdeadbeef` na linha main+23, onde é executada uma instrução `mov`, que coloca essa variável no local da memória `rbp-0x28`, que na linha seguinte é movida para `eax`.

Então, na próxima linha, é feita uma comparação do que está em `eax` com a variável `0xcafebabe`, que, caso não seja verdadeira (o que seria esperado, por ela ser `0xdeadbeef`), pulará para outra parte do código.

Então, o objetivo é mudar o resultado dessas instruções para não efetuar o jump (na instrução `jne`), existem duas formas de fazer isso:

### Primeira Forma

Podemos mudar o que está em `eax` logo antes da comparação, para isso, basta usar os comandos no gdb:

```
pwndbg> b *main+33 # Adiciona o breakpoint logo antes da comparação
pwndbg> r # Roda o programa até o breakpoint

... (execução do programa até o breakpoint)

pwndbg> set $eax=0xcafebabe
pwndbg> c # Para continuar a execução
```

O que imprimirá a flag

### Segunda Forma

É possível mudar o resultado da comparação mesmo ela estando errada.

A instrução `jne` faz uso de parte do registrador `EFLAGS`, que é composto de várias flags para operações aritméticas (sim, a comparação entre inteiros é implementada como uma operação de subtração). Neste caso em específico o bit utilizado é o Zero Flag (ou ZF), o que pode ser conferido [neste site](http://unixwiz.net/techtips/x86-jumps.html), que por acaso é o [6o bit](https://en.wikipedia.org/wiki/FLAGS_register) do registrador EFLAGS.

Então, podemos criar uma variável `ZF` no gdb e utilizá-la para setar esse bit do registrador EFLAGS como 1, o que vai fazer com que o `jne` não faça o jump.

```
pwndbg> b *main+38
pwndbg> r 
...
pwndbg> set $ZF = 6
pwndbg> set $eflags |= (1 << $ZF) 
pwndbg> c
```

Neste caso é feito um OR lógico entre o registrador `eflags` e o 6o bit (1 << 6), setando como verdadeiro e manipulando o fluxo do programa, o que imprime a flag.

Flag: `Ganesh{fl0w_m4nipulator}`

## Não chore <a name="naochore"></a>

```
Qual o valor retornado pelo programa em anexo?
```

```
    mov     ecx,4
    mov     eax,16
    add     ebx,4
    add     ecx,eax
    sub     ebx,eax
    xor     ebx,ebx
    mov     eax,1
    int     0x80
```

`int 0x80` faz uma chamada de sistema

ABI de syscalls do linux:

```
       arch/ABI      arg1  arg2  arg3  arg4  arg5  arg6  arg7  Notes
       -------------------------------------------------------------
       i386          ebx   ecx   edx   esi   edi   ebp   -
```

O número da syscall é armazenado em `eax`, onde 1 é exit.

O primero argumento da syscall exit é o código de saída, que fica armazenado em `ebx`,
que é 0 por causa do `xor ebx, ebx`

Flag: `0`

## Pode chorar <a name="podechorar"></a>

```
E agora, qual o valor retornado pelo programa em anexo?
```

```
    mov eax,-1
    mov ebx,3
    xor eax,ebx
    add ebx,ebx
    xor eax,ebx
    mov ebx,10
    and eax,ebx
    xor ebx,ebx
    cmp eax,ebx
    jz isZero
notZero:
    mov ebx,eax
    jmp exit
isZero:
    mov ebx,-1
exit:
    mov eax,1
    int 0x80
```

| line | eax | ebx |
|------|-----|-----|
| `mov eax, -1` | -1 | ? |
| `mov ebx, 3` | -1 | 3 |
| `xor eax, ebx` | -4 | 3 |
| `add ebx, ebx` | -4 | 6 |
| `xor eax, ebx` | -6 | 6 |
| `mov ebx, 10` | -6 | 10 |
| `and eax, ebx` | 10 | 10 |
| `xor ebx, ebx` | 10 | 0 |
| `cmp eax, ebx` | - | - |
| `jz isZero` | - | - |
| não pula, eax != ebx | - | - |
| `mov ebx, eax` | 10 | 10 |
| `jmp exit` | - | - |
| `mov eax, 1` | 1 | 10 |
| `int 0x80` | - | - |

Flag: `10` 

## So Many Words <a name="somanywords"></a>

```
Perdi meu trabalho de BD, tenho certeza que algumas informações importantes estavam lá dentro, pode me ajudar a recuperar?

A flag está no formato Ganesh{}
```

Tomando que existe texto importante no binário, o comando "strings chall1" pode mostrar eles.

```
$strings chall1
/lib64/ld-linux-x86-64.so.2
libsqlite3.so.0
_ITM_deregisterTMCloneTable
__gmon_start__
_ITM_registerTMCloneTable
sqlite3_close
sqlite3_errmsg
sqlite3_open
sqlite3_extended_result_codes
sqlite3_exec
[...]
```

Podemos reduzir a quantidade de strings para buscar sabendo que a sintaxe do texto buscado é "Ganesh{<FLAG>}". O comando grep pode fazer isso.

```
$strings chall1 | grep Ganesh{
Ganesh{using_grep_is_easy}
```


## Crackme <a name="crackme"></a>

```
Achei esse programa na internet, mas ele pede uma chave... Será que você consegue crackear?
```

Abrindo no gdb, e executando `disassemble main` podemos ver que a *main* possui uma função chamada *check*:
```
Dump of assembler code for function main:
   [...]
   0x000000000000130a <+59>:    add    rax,0x8
   0x000000000000130e <+63>:    mov    rax,QWORD PTR [rax]
   0x0000000000001311 <+66>:    mov    rdi,rax
   0x0000000000001314 <+69>:    call   0x1149 <check>
   0x0000000000001319 <+74>:    mov    eax,0x0
   0x000000000000131e <+79>:    leave
   0x000000000000131f <+80>:    ret
End of assembler dump.
```
Vendo o disassembly da função *check* com `disassemble check`, vemos que a função faz comparações com diversos caracteres.
```
Dump of assembler code for function check:
   [...]
   0x0000000000001160 <+23>:    cmp    al,0x33
   0x0000000000001162 <+25>:    jne    0x12cc <check+387>
   [...]
   0x0000000000001173 <+42>:    cmp    al,0x5f
   0x0000000000001175 <+44>:    jne    0x12cc <check+387>
   [...]
   0x0000000000001186 <+61>:    cmp    al,0x73
   0x0000000000001188 <+63>:    jne    0x12cc <check+387>
   [...]
   0x0000000000001199 <+80>:    cmp    al,0x73
   0x000000000000119b <+82>:    jne    0x12cc <check+387>
   [...]
   0x00000000000011ac <+99>:    cmp    al,0x6e
   0x00000000000011ae <+101>:   jne    0x12cc <check+387>
   [...]
   0x00000000000011bf <+118>:   cmp    al,0x6d
   0x00000000000011c1 <+120>:   jne    0x12cc <check+387>
   [...]
   0x00000000000011d2 <+137>:   cmp    al,0x7b
   0x00000000000011d4 <+139>:   jne    0x12cc <check+387>
   [...]
   0x00000000000011e5 <+156>:   cmp    al,0x61
   0x00000000000011e7 <+158>:   jne    0x12cc <check+387>
   [...]
   0x00000000000011f8 <+175>:   cmp    al,0x6a
   0x00000000000011fa <+177>:   jne    0x12cc <check+387>
   [...]
   0x000000000000120b <+194>:   cmp    al,0x7d
   0x000000000000120d <+196>:   jne    0x12cc <check+387>
   [...]
   0x000000000000121e <+213>:   cmp    al,0x73
   0x0000000000001220 <+215>:   jne    0x12cc <check+387>
   [...]
   0x0000000000001231 <+232>:   cmp    al,0x35
   0x0000000000001233 <+234>:   jne    0x12cc <check+387>
   [...]
   0x0000000000001244 <+251>:   cmp    al,0x66
   0x0000000000001246 <+253>:   jne    0x12cc <check+387>
   [...]
   0x0000000000001257 <+270>:   cmp    al,0x31
   0x0000000000001259 <+272>:   jne    0x12cc <check+387>
   [...]
   0x0000000000001266 <+285>:   cmp    al,0x74
   0x0000000000001268 <+287>:   jne    0x12cc <check+387>
   [...]
   0x0000000000001275 <+300>:   cmp    al,0x75
   0x0000000000001277 <+302>:   jne    0x12cc <check+387>
   [...]
   0x0000000000001284 <+315>:   cmp    al,0x65
   0x0000000000001286 <+317>:   jne    0x12cc <check+387>
   [...]
   0x000000000000128f <+326>:   cmp    al,0x47
   0x0000000000001291 <+328>:   jne    0x12cc <check+387>
   [...]
   0x000000000000129e <+341>:   cmp    al,0x5f
   0x00000000000012a0 <+343>:   jne    0x12cc <check+387>
   [...]
   0x00000000000012ad <+356>:   cmp    al,0x68
   0x00000000000012af <+358>:   jne    0x12cc <check+387>
   [...]
   0x00000000000012bc <+371>:   cmp    al,0x30
   0x00000000000012be <+373>:   jne    0x12cc <check+387>
   [...]
End of assembler dump.
```
Pegando esses caracteres e printando-os usando o comando do gdb `print (char) [valor]`, temos:
```
(gdb) print (char) 0x33
$2 = 51 '3'
(gdb) print (char) 0x5f
$3 = 95 '_'
(gdb) print (char) 0x73
$4 = 115 's'
(gdb) print (char) 0x73
$5 = 115 's'
(gdb) print (char) 0x6e
$6 = 110 'n'
(gdb) print (char) 0x6d
$7 = 109 'm'
(gdb) print (char) 0x7b
$8 = 123 '{'
(gdb) print (char) 0x61
$9 = 97 'a'
(gdb) print (char) 0x6a
$10 = 106 'j'
(gdb) print (char) 0x7d
$11 = 125 '}'
(gdb) print (char) 0x73
$12 = 115 's'
(gdb) print (char) 0x35
$13 = 53 '5'
(gdb) print (char) 0x66
$14 = 102 'f'
(gdb) print (char) 0x31
$15 = 49 '1'
(gdb) print (char) 0x74
$16 = 116 't'
(gdb) print (char) 0x75
$17 = 117 'u'
(gdb) print (char) 0x65
$18 = 101 'e'
(gdb) print (char) 0x47
$19 = 71 'G'
(gdb) print (char) 0x5f
$20 = 95 '_'
(gdb) print (char) 0x68
$21 = 104 'h'
(gdb) print (char) 0x30
$22 = 48 '0'
```
Juntando todos eles formam a string:
`3_ssnm{aj}s5f1tueG_h0`

Colocando como arguento a string de teste `abcdefghijklmnopqrstu` e breakpoints em cada `cmp`, podemos descobrir a posição de cada caractere da flag com `print (char) $al`. Por exemplo, o caractere '3' é comparado no primeiro `cmp` com o caractere 'p' da nossa string de teste. Como 'p' é a 16ª letra dessa string, sabemos que '3' será o 16º caractére da senha ou flag.

Desembaralhando-os, temos a flag `Ganesh{ju5t_s0m3_1fs}` que pode ser verificada via:
```
$ ./crack_me Ganesh{ju5t_s0m3_1fs}
y0u_ju5t_f0und_th3_k3y
```

Flag: `Ganesh{ju5t_s0m3_1fs}`

## Code <a name="code"></a>

```
Esse programa contem um codigo muito importante, mas nao conseguimos entender o que ele quer dizer. Qual a mensagem contida no programa?
```

Rodando o programa, obtemos a string `jdqhvk{dyh_fdhvdu}`, que tem o formato de uma flag,
mas está provavelmente codificada. Testando uma cifra de césar (rot13.com), obtemos a flag
com ROT23

Flag: `ganesh{ave_caesar}`

## Você sabe crackear MD5? <a name="sabemd5"></a>

```
Tente crackear o nosso checker de md5...
```

O programa calcula o md5 do primeiro argumento (argv[1]) e compara com uma constante. Se forem iguais, ele
calcula e printa a flag. Usando o gdb, basta parar o codigo na comparação de string e executar o código que
printa a flag.

```
Dump of assembler code for function main:
   //...
   0x0000000000001474 <+333>:   call   0x11c9 <md5sum>
   0x0000000000001479 <+338>:   lea    rax,[rbp-0x80]
   0x000000000000147d <+342>:   lea    rdx,[rip+0x1bf4]        # 0x3078
   0x0000000000001484 <+349>:   mov    rsi,rax
   0x0000000000001487 <+352>:   lea    rdi,[rip+0x1c5f]        # 0x30ed
   0x000000000000148e <+359>:   mov    eax,0x0
   0x0000000000001493 <+364>:   call   0x1070 <printf@plt>
   0x0000000000001498 <+369>:   lea    rax,[rbp-0x80]
   0x000000000000149c <+373>:   lea    rsi,[rip+0x1bd5]        # 0x3078
   0x00000000000014a3 <+380>:   mov    rdi,rax
   0x00000000000014a6 <+383>:   call   0x1090 <strcmp@plt>
   0x00000000000014ab <+388>:   mov    DWORD PTR [rbp-0x84],eax
   0x00000000000014b1 <+394>:   cmp    DWORD PTR [rbp-0x84],0x0
   0x00000000000014b8 <+401>:   jne    0x150d <main+486>
   0x00000000000014ba <+403>:   mov    DWORD PTR [rbp-0x88],0x0
   //... codigo que printa a flag ...

   //codigo que diz que voce errou
   0x000000000000150d <+486>:   lea    rdi,[rip+0x1bf3]        # 0x3107
   0x0000000000001514 <+493>:   call   0x1040 <puts@plt>
   //...
```

Observe a instrução `<+383>`, que faz a comparação das strings. Depois, em `<+401>`, se forem
diferentes o código pula para outro lugar. Se pararmos a execução nessa instrução e pularmos ela,
a flag será printada. Pulando para `<+403>` é suficiente:

```
gdb md5_is_broken
(gdb) break *(main+401)
(gdb) run aaaaaaaa
(gdb) jump *(main+403)
```

Flag: `Ganesh{wh0_n33d5_brut3f0rc3_wh3n_y0u_have_gdb}`  

## hacker_test <a name="hackertest"></a>

```
O teste final para se transformar em um hackemen de verdade é passar nesse teste. Sera que voce consegue?

A flag não está no formato usual.
```

Para análise do binário podemos usar o comando "objdump -d hacker_test".
Com isso podemos observar uma função com nome suspeito na main, a função "Flag".

```
000000000000131b <main>:
[...]
    1349:       48 8b 00                mov    (%rax),%rax
    134c:       48 89 c7                mov    %rax,%rdi
    134f:       e8 60 ff ff ff          callq  12b4 <Flag>
    1354:       85 c0                   test   %eax,%eax
    1356:       74 0e                   je     1366 <main+0x4b>
[...]
```

Olhando a função Flag observa-se outras funções com nome suspeito, as funções "sao_as" e "chamada"

```
00000000000012b4 <Flag>:
[...]
    12dc:       48 89 c7                mov    %rax,%rdi
    12df:       e8 ae ff ff ff          callq  1292 <sao_as>
    12e4:       89 45 ec                mov    %eax,-0x14(%rbp)

[...]
    12f3:       48 89 c7                mov    %rax,%rdi
    12f6:       e8 3f ff ff ff          callq  123a <chamada>
    12fb:       89 45 f0                mov    %eax,-0x10(%rbp)
[...]
```

Montando a estrutura de chamada de funções tem-se o seguinte resultado

```
Flag
	sao_as
		funcoes_em
			ordem_de
	chamada
```

Pelos nomes podemos propor como flag:

```
Flag_sao_as_funcoes_em_ordem_de_chamada
```
## ghidra_challenge <a name="guidrachall"></a>

```
Queremos crackear o melhor programa de engenharia reversa que o dinheiro pode comprar, voce consegue descobrir a chave de ativação?
```

Pelo nome do chall começamos a analisar o código com a ferramenta "ghidra" para análise do binário. Com ela podemos observar esse decompile para a main.

```
undefined8 main(int iParm1,undefined8 *puParm2)

{
  int iVar1;
  
  if (iParm1 < 2) {
    printf("usage: ./%s <flag>\n",*puParm2);
  }
  else {
    shuffle(puParm2[1]);
    iVar1 = compare(puParm2[1]);
    if (iVar1 == 0) {
      puts("Wrong activation key");
    }
    else {
      puts("The program has been successfully activated");
    }
  }
  return 0;
}
```

Podemos renomear algumas variáveis para melhor clareza.

```
int main(int argc,char **argv)

{
  int status;
  
  if (argc < 2) {
    printf("usage: ./%s <flag>\n",*argv);
  }
  else {
    shuffle(argv[1]);
    status = compare(argv[1]);
    if (status == 0) {
      puts("Wrong activation key");
    }
    else {
      puts("The program has been successfully activated");
    }
  }
  return 0;
}
```

Daí observa-se que o programa recebe como parâmetro uma string, transmite ela para a função "shuffle" (que deve embaralhar os caracteres) e depois passa essa string para o comando "compare" (que provavelmente compara com o resultado correto).
Olhando a função compare talvez seja possível entender como ele verifica a chave.

```
undefined8 compare(char *pcParm1)

{
  size_t sVar1;
  undefined8 uVar2;
  long in_FS_OFFSET;
  int local_98;
  int local_88 [4];
  undefined4 local_78;
  undefined4 local_74;
  undefined4 local_70;
  undefined4 local_6c;
  undefined4 local_68;
  undefined4 local_64;
  undefined4 local_60;
  undefined4 local_5c;
  undefined4 local_58;
  undefined4 local_54;
  undefined4 local_50;
  undefined4 local_4c;
  undefined4 local_48;
  undefined4 local_44;
  undefined4 local_40;
  undefined4 local_3c;
  undefined4 local_38;
  undefined4 local_34;
  undefined4 local_30;
  undefined4 local_2c;
  undefined4 local_28;
  undefined4 local_24;
  undefined4 local_20;
  long local_10;
  
  local_10 = *(long *)(in_FS_OFFSET + 0x28);
  local_88[0] = 4;
  local_88[1] = 7;
  local_88[2] = 8;
  local_88[3] = 0x11;
  local_78 = 0x28;
  local_74 = 4;
  local_70 = 0x16;
  local_6c = 0x11;
  local_68 = 0x20;
  local_64 = 0x12;
  local_60 = 0;
  local_5c = 0x15;
  local_58 = 4;
  local_54 = 0xd;
  local_50 = 0x11;
  local_4c = 0x35;
  local_48 = 0x34;
  local_44 = 0;
  local_40 = 0x22;
  local_3c = 0x29;
  local_38 = 7;
  local_34 = 0xe;
  local_30 = 0x12;
  local_2c = 0x20;
  local_28 = 3;
  local_24 = 3;
  local_20 = 4;
  sVar1 = strlen(pcParm1);
  if ((int)sVar1 == 0x1b) {
    local_98 = 0;
    while (local_98 < 0x1b) {
      if ("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz[]"[(long)local_88[(long)local_98]]
          != pcParm1[(long)local_98]) {
        uVar2 = 0;
        goto LAB_001013ee;
      }
      local_98 = local_98 + 1;
    }
    uVar2 = 1;
  }
  else {
    uVar2 = 0;
  }
LAB_001013ee:
  if (local_10 != *(long *)(in_FS_OFFSET + 0x28)) {
                    /* WARNING: Subroutine does not return */
    __stack_chk_fail();
  }
  return uVar2;
}
```

Inicialmente é bom modificar alguns nomes e tipos que o ghidra não conseguiu perceber.
Esse grande número de variáveis na função indica que existe um vetor. Podemos recuperar ele mudando o tipo de "local\_88" por int[27] e renomear para "number_sequence".
"sVar1" recebe o comprimento de uma string e pode ser nomeado como "len". "local\_98" parece ser um contador e podemos chamá-lo de "i". "uVar2" recebe 0 se a verificação falhar e 1 se funcionar e podemos chamar de "status". Por fim local\_10 é um protetor de stack e podemos chamar de "stack\_protector"
Com isso tem-se esse código mais legível:

```
undefined8 compare(char *pcParm1)

{
  size_t len;
  undefined8 status;
  long in_FS_OFFSET;
  int i;
  int number_sequence [27];
  long stack_protector;
  
  stack_protector = *(long *)(in_FS_OFFSET + 0x28);
  number_sequence[0] = 4;
  number_sequence[1] = 7;
  number_sequence[2] = 8;
  number_sequence[3] = 0x11;
  number_sequence[4] = 0x28;
  number_sequence[5] = 4;
  number_sequence[6] = 0x16;
  number_sequence[7] = 0x11;
  number_sequence[8] = 0x20;
  number_sequence[9] = 0x12;
  number_sequence[10] = 0;
  number_sequence[11] = 0x15;
  number_sequence[12] = 4;
  number_sequence[13] = 0xd;
  number_sequence[14] = 0x11;
  number_sequence[15] = 0x35;
  number_sequence[16] = 0x34;
  number_sequence[17] = 0;
  number_sequence[18] = 0x22;
  number_sequence[19] = 0x29;
  number_sequence[20] = 7;
  number_sequence[21] = 0xe;
  number_sequence[22] = 0x12;
  number_sequence[23] = 0x20;
  number_sequence[24] = 3;
  number_sequence[25] = 3;
  number_sequence[26] = 4;
  len = strlen(pcParm1);
  if ((int)len == 0x1b) {
    i = 0;
    while (i < 0x1b) {
      if ("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz[]"[(long)number_sequence[(long)i]]
          != pcParm1[(long)i]) {
        status = 0;
        goto LAB_001013ee;
      }
      i = i + 1;
    }
    status = 1;
  }
  else {
    status = 0;
  }
LAB_001013ee:
  if (stack_protector != *(long *)(in_FS_OFFSET + 0x28)) {
                    /* WARNING: Subroutine does not return */
    __stack_chk_fail();
  }
  return status;
}
```

Daí pode-se ver que o que essa função faz é comparar o parâmetro de entrada com a sequência de "number_sequence", que serve como uma lista de íncices para a string "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz[]". Fazendo a sequência manualmente pode-se obter a chave correta após a operação de "shuffle". O seguinte código python realiza a operação:

```
number_sequence = [0x4, 0x7, 0x8, 0x11, 0x28, 0x4, 0x16, 0x11, 0x20, 0x12, 0x0, 0x15, 0x4, 0xd, 0x11, 0x35, 0x34, 0x0, 0x22, 0x29, 0x7, 0xe, 0x12, 0x20, 0x3, 0x3, 0x4]
string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz[]"

for num in number_sequence:
	print(string[num], end="")
print()
```

Daí tem-se que a chave após operação de shuffle é *EHIRoEWRgSAVENR][AipHOSgDDE*.

Agora é importante entender o funcionamento do shuffle para desfazer a operação. O código já propriamente nomeado é o seguinte:

```
void shuffle(char *pcParm1)

{
  int len2;
  size_t len;
  uint j;
  int i;
  
  len = strlen(pcParm1);
  len2 = (int)len;
  i = 1;
  while (i < 3) {
    j = 0;
    while ((int)j <= len2 - i) {
      rotate(pcParm1,(ulong)((len2 - i) + 1),(ulong)j);
      j = j + i;
    }
    i = i + 1;
  }
  j = 0;
  while ((int)j < len2) {
    pcParm1[(long)(int)j] = pcParm1[(long)(int)j] ^ 0x20;
    j = j + 1;
  }
  return;
}
```

Aqui observa-se que a string passa por diversas operações de rotação e ao final cada caractere recebe um xor de 0x20.
A parte de xor de 0x20 na tabela ascii simplesmente permuta maiúscula com minúscula e os caracteres "[" e "]" se tornam "{" e "}". Isso pode ser visto com esse código em python:

```
c = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz[]"
for i in c:
    print(chr(ord(i)^0x20), end="")
```

O programa imprime "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ{}"

Para a parte de permutações, existe um truque simples para acelerar o processo. Ele consiste em rodar o código com uma string conhecida e verificar como a posição dos caracteres mudou no final. Por exemplo, uma mudança "abcd"->"ACBD" mostra com clareza que o algoritmo permuta o segundo e o terceiro caracteres.

Para isso podemos usar o gdb para observar a string antes e depois da comparação.
Executamos o comando "gdb ghidra_challenge"
Através do comando "disassemble main" podemos ver o momento que a função shuffle é chamada:

```
Dump of assembler code for function main:
[...]
0x000055555555543e <+58>:	mov    (%rax),%rax
0x0000555555555441 <+61>:	mov    %rax,%rdi
0x0000555555555444 <+64>:	callq  0x5555555551dc <shuffle>
0x0000555555555449 <+69>:	mov    -0x10(%rbp),%rax
0x000055555555544d <+73>:	add    $0x8,%rax
[...]
```

Daí podemos ver que a chamada para shuffle acontece na posição main+64, a instrução seguinte acontece em main+69 e que a string está sendo passada pelo registrador rdi. Com essas informações é possível analisar a memória.
A seguinte seqência de comandos ilustra o processo

```
(gdb) break *main+64
Breakpoint 1 at 0x1444
(gdb) break *main+69
Breakpoint 2 at 0x1449
(gdb) run abcdefghijklmnopqrstuvwxyzA
Starting program: /home/user/ghidra_challenge abcdefghijklmnopqrstuvwxyzA

Breakpoint 1, 0x0000555555555444 in main ()
(gdb) x/s $rdi
0x7fffffffe995:	"abcdefghijklmnopqrstuvwxyzA"
(gdb) continue
Continuing.

Breakpoint 2, 0x0000555555555449 in main ()
(gdb) x/s $rdi
0x7fffffffe995:	"DFJLPRVXAEMQYCSaGBNTIUOHKZW"
```

Daí o processo reverso do resultado "EHIRoEWRgSAVENR][AipHOSgDDE" pode ser obtido manualmente:

```
abcdefghijklmnopqrstuvwxyzA    #antes do xor 0x20
ABCDEFGHIJKLMNOPQRSTUVWXYZa    #antes do shuffle
DFJLPRVXAEMQYCSaGBNTIUOHKZW    #resultado

EHIRoEWRgSAVENR][AipHOSgDDE    #resultado
gANESH[gHIDRAiSoVERpOWERED]    #desfeito o shuffle
Ganesh{GhidraIsOverPowered}    #desfeito o xor 0x20
```

## JFCH <a name="jfch"></a>

```
Muitas vezes o caminho atual não leva a lugar nenhum, para obter resultados é necessário tomar novas decisões
```

Se olharmos as funções do programa (`nm JFCH | grep -P '[0-9a-f]+ T .+'`), existe uma chamada `gera_flag`. Que tal rodar ela?

```
gdb -q JFCH
(gdb) break main
(gdb) run
(gdb) print (char*)gera_flag()
```

Flag: `Ganesh{voce_traiu_o_fluxo}`  

## Entenda-me <a name="entendame"></a>

```
Na previsão dos resultados jaz a verdadeira resposta, apenas o computeiro escolhido pode compreender algo sem a necessidade de executar antes!
```

A função main printa `printf("Ganesh{%d_eh_a_resposta}", func(10));`, o que nos diz como formatar
a flag. Basta calcular func(10).

Func (`objdump -D -M intel -j .text <binario>`):

```
000000000000064a <func>:
 64a:   55                      push   rbp
 64b:   48 89 e5                mov    rbp,rsp
 64e:   53                      push   rbx
 64f:   48 83 ec 18             sub    rsp,0x18
 653:   89 7d ec                mov    DWORD PTR [rbp-0x14],edi
 656:   83 7d ec 01             cmp    DWORD PTR [rbp-0x14],0x1
 65a:   75 07                   jne    663 <func+0x19>
 65c:   b8 01 00 00 00          mov    eax,0x1
 661:   eb 2b                   jmp    68e <func+0x44>
 663:   83 7d ec 02             cmp    DWORD PTR [rbp-0x14],0x2
 667:   75 07                   jne    670 <func+0x26>
 669:   b8 01 00 00 00          mov    eax,0x1
 66e:   eb 1e                   jmp    68e <func+0x44>
 670:   8b 45 ec                mov    eax,DWORD PTR [rbp-0x14]
 673:   83 e8 01                sub    eax,0x1
 676:   89 c7                   mov    edi,eax
 678:   e8 cd ff ff ff          call   64a <func>
 67d:   89 c3                   mov    ebx,eax
 67f:   8b 45 ec                mov    eax,DWORD PTR [rbp-0x14]
 682:   83 e8 02                sub    eax,0x2
 685:   89 c7                   mov    edi,eax
 687:   e8 be ff ff ff          call   64a <func>
 68c:   01 d8                   add    eax,ebx
 68e:   48 83 c4 18             add    rsp,0x18
 692:   5b                      pop    rbx
 693:   5d                      pop    rbp
 694:   c3                      ret
```

O único argumento da função está no registrador `rdi`, cujos 32 bits menos significativos podem
ser acessados pelo registrador `edi`

Na instrucão `653`, o argumento é salvo em `rbp-0x14`.

Depois, ele é comparado com 1, e se for diferente, a execução passa para `663`. Caso contrário, a função
retorna 1. Traduzindo para C:

```c
int func(int i) {
    if(i == 1) { return 1; }
    //codigo em 663
}
```

Em `663`, o argumento é comparado com 2, e se for igual, 1 é retornado. Caso contrário, a execução passa pra 670.

```c
int func(int i) {
    if(i == 1) { return 1; }
    if(i == 2) { return 1; }
    //codigo em 670
}
```

Em 670, calcula-se `func(i - 1)` e `func(i - 2)`, retornando a sua soma.

```c
int func(int i) {
    if(i == 1) { return 1; }
    if(i == 2) { return 1; }
    return func(i - 1) + func(i - 2);
}
```

`func` é a função de fibbonacci!

Flag: `Ganesh{55_eh_a_resposta}`
