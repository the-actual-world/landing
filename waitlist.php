<?php

include 'include/config.inc.php';

if (isset($_POST['email'])) {
  $email = $_POST['email'];
  $receiveEmailUpdates = isset($_POST['receiveEmailUpdates']) ? 1 : 0;

  $sql = "SELECT * FROM waitlist WHERE email = '$email'";
  $result = my_query($sql);

  if (count($result) > 0) {
    my_query("UPDATE waitlist SET receber_atualizacoes = $receiveEmailUpdates WHERE email = '$email'");
    redirect('index.php?waitlist=1');
  }

  $sql = "INSERT INTO waitlist (email, receber_atualizacoes) VALUES ('$email', $receiveEmailUpdates)";
  my_query($sql);

  add_log('waitlist', 'ADD_EMAIL', $email);

  redirect('index.php?waitlist=1');
}