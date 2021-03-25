<?php
	/* Atenção: se você vai usar um banco de dados compartilhado com outras coisas, faça com que o usuário DB_USER tenha acesso apenas às tabelas dele. */

	/* Definição das tabelas (devem ser criadas anteriormente):
	*
	* TABELA 'usuarios':
	* 	Campo 'nome' do tipo TEXT;
	* 	Campo 'senha' do tipo TEXT;
	* 	Campo 'nivel_usuario' do tipo INT (valor default: 0).
	*
	* O usuário 'DB_USER' deve ter poder para ler e escrever dados na tabela 'usuarios'.
	* Mais nenhuma permissão é necessária, e como o sistema tem propositalmente SQLInjection, nem é uma boa ideia deixar muitas permissões ativas.
	*
	*/

	define('BD_USER', 'user_chall_6');     /* Usuário para acessar a base de dados MySQL. */
	define('BD_PASS', '7PPoabF7w08TquuC'); /* Senha do usuário anterior. */
	define('BD_NAME', 'db_chall_06');      /* Nome da base de dados. */
	$conexao = mysqli_connect('localhost', BD_USER, BD_PASS);
	$link = mysqli_select_db($conexao, BD_NAME);
	