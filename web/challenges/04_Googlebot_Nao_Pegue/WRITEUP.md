# Googlebot, não pegue!

**Flag:** `Ganesh{W3B?_345Y_P345Y_L3M0N_5QU33ZY}`

Ao entrar no site, aparentemente não há nada para se ver, sem requisições especiais, nenhum link interno. Me chamou atenção não ter nenhuma página além da '/', então estava quase setando um dirbuster quando lembrei da existência do arquivo robots.txt, mas não achei que fosse realmente ter um.

### /robots.txt:

```text
# Pensando mais a longo prazo, a execução dos pontos do programa nos obriga à análise das regras de conduta normativas. 
# Acima de tudo, é fundamental ressaltar que a contínua expansão de nossa atividade faz parte de um processo de gerenciamento das diretrizes de desenvolvimento para o futuro. 
# Assim mesmo, a consulta aos diversos militantes aponta para a melhoria dos métodos utilizados na avaliação de resultados. 
# O cuidado em identificar pontos críticos na estrutura atual da organização assume importantes posições no estabelecimento do sistema de formação de quadros que corresponde às necessidades. 
# Do mesmo modo, a mobilidade dos capitais internacionais estende o alcance e a importância das novas proposições. 
# Todavia, o consenso sobre a necessidade de qualificação ainda não demonstrou convincentemente que vai participar na mudança das direções preferenciais no sentido do progresso.
User-agent: *
Disallow: /
Disallow: /w/
Disallow: /api/
Disallow: /trap/
Disallow: /test/Special:
Disallow: /test/Spezial:
Disallow: /test/ganesh/flag.php
Disallow: /test/Spesial:
Disallow: /test/Special%3A
Disallow: /test/Spezial%3A
Disallow: /test/Spesial%3A
```

Lá tinha várias rotas proibidas. Uma delas era a /test/ganesh/flag.php, onde estava guardada a flag.

