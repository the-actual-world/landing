<?php

include_once '../include/config.inc.php';

$email = $_POST['email'] ?? null;
$nome = $_POST['nome'] ?? null;
$titulo = $_POST['titulo'] ?? null;
$mensagem = $_POST['mensagem'] ?? null;

if ($email && $nome && $titulo && $mensagem) {
  my_query("INSERT INTO mensagens (email, nome, titulo, mensagem, data) VALUES ('$email', '$nome', '$titulo', '$mensagem', NOW())");

  add_log('contacto', 'SUCESSO_MANDAR_MENSAGEM');
  redirect($arrConfig['url_site'] . '/contact?success');
}

add_log('contacto', 'ERRO_MANDAR_MENSAGEM');
redirect($arrConfig['url_site'] . '/contact?error');
