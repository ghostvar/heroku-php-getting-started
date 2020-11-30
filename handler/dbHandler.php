<?php

$db = $app['controllers_factory'];
$db->post('/', function () use ($app) {
  $pesan = "";
  // buat nerima form
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $res = $app['pdo']->prepare("INSERT INTO test_table (name) VALUES ('{$name}')");
    if ($res->execute()) {
      $pesan = "alert('Data tersimpan !');";
      $_SESSION['nama'] = $name;
    } else {
      $pesan = "alert('Data gagal tersimpan !');";
    }
  }

  return "<script>{$pesan} window.location = \"/db\";</script>";
});

$db->get('/', function () use ($app) {
  $res = $app['pdo']->prepare('SELECT name FROM test_table');
  $res->execute();

  $html = "";
  while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $html .= "<li>{$row['name']}</li>";
  }

  $form = '
    <form action="" method="post">
      <input type="text" name="name">
      <button name="submit" type="submit">Simpan</button>
    </form>
  ';

  return `<ul>` . $html . `</ul>` . $form . '<br>NAME: ' . @$_SESSION['nama'];
});

return $db;
