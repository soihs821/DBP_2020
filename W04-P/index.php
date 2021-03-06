<?php
  $link = mysqli_connect('localhost:3307', 'root', 'root1234', 'dbp');
  $query = "SELECT * FROM w02p";
  $result = mysqli_query($link, $query);
  $list ='';
  while ($row = mysqli_fetch_array($result)) {
      $escaped_title = htmlspecialchars($row['title']);
      $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$escaped_title}</a></li>";
  }

  $article = array(
    'title' => 'Welcome',
    'description' => 'Database is ...'
  );

  $update_link = '';
  $delete_link = '';
  $author = '';

  if (isset($_GET['id'])) { // id 있을 때 동작되는 애들.
      $filtered_id = mysqli_real_escape_string($link, $_GET['id']);
      $query = "SELECT * FROM w02p LEFT JOIN price ON
      w02p.price_id = price.id WHERE w02p.id={$filtered_id}";

      $result = mysqli_query($link, $query);
      $row = mysqli_fetch_array($result);
      $article['title'] = htmlspecialchars($row['title']);
      $article['description'] = htmlspecialchars($row['description']);
      $article['price'] = htmlspecialchars($row['price']);

      $update_link = '<a href="update.php?id='.$_GET['id'].'">update</a>';
      $delete_link = '
        <form action="process_delete.php" method="post">
          <input type="hidden" name="id" value="'.$_GET['id'].'">
          <input type="submit" value="delete">
        </form>
      ';

      $author = "<p>by {$article['name']}</p>";
  }
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ALPHAFRUIT</title>
  </head>
  <body>
    <h1><a href="index.php">ALPHAFRUIT</a></h1>
    <a href="price.php">price</a>
    <ol><?= $list ?></ol>
    <a href="create.php">create</a>
    <?= $update_link ?>
    <?= $delete_link ?>
    <h2><?= $article['title'] ?></h2>
    <?= $article['description'] ?>
    <?= $author ?>
  </body>
</html>
