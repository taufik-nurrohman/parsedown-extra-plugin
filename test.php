<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta content="width=device-width" name="viewport">
    <meta charset="utf-8">
    <title><?php echo isset($_GET['file']) ? $_GET['file'] : 'Test'; ?></title>
  </head>
  <body>
  <?php

if (isset($_GET['file']) && is_file(__DIR__ . '/test/test.' . $_GET['file'] . '.php')) {
    require __DIR__ . '/test/Parsedown.php';
    require __DIR__ . '/test/ParsedownExtra.php';
    require __DIR__ . '/ParsedownExtraPlugin.php';
    $parser = new ParsedownExtraPlugin;
    require __DIR__ . '/test/test.' . $_GET['file'] . '.php';
    exit;
}

echo '<ul>';

foreach (glob(__DIR__ . '/test/test.*.php') as $v) {
    $n = substr(basename($v, '.php'), 5);
    echo '<li><a href="?file=' . $n . '" target="_blank">' . $n . '</a>';
}

echo '</ul>';

  ?>
  </body>
</html>