<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Halaman Login</h1>
  <?php
    $dbopts = parse_url(getenv('DATABASE_URL'));
    echo $dbopts["user"];
  ?>
</body>
</html>