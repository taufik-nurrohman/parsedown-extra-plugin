<?php error_reporting(E_ALL); ?>
<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta content="width=device-width" name="viewport">
    <meta charset="utf-8">
    <title><?php echo isset($_GET['file']) ? $_GET['file'] : 'Test'; ?></title>
  </head>
  <body><?php

if (isset($_GET['file']) && is_file(__DIR__ . '/test/test.' . $_GET['file'] . '.php')) {
    require __DIR__ . '/../../autoload.php';
    $Parsedown = new ParsedownExtraPlugin;
    $Text = "";
    require __DIR__ . '/test/test.' . $_GET['file'] . '.php';
    echo '<h1>Input</h1>';
    echo '<pre style="border:2px solid red;padding:2em;white-space:pre-wrap;">';
    echo htmlspecialchars($Text);
    echo '</pre>';
    $Html = $Parsedown->text($Text);
    echo '<h1>Output</h1>';
    echo '<div style="border:2px solid green;padding:2em;">';
    echo $Html;
    echo '</div>';
    echo '<pre style="border:2px solid blue;padding:2em;white-space:pre-wrap;">';
    echo preg_replace_callback('/&lt;.*?&gt;|&amp;#?[a-z\d]+;/', function($Matches) {
        if (substr($Matches[0], -4) === '&gt;') {
            return '<span style="background:skyblue;color:blue;">' . $Matches[0] . '</span>';
        }
        if (substr($Matches[0], -1) === ';') {
            return '<span style="background:pink;color:red;">' . $Matches[0] . '</span>';
        }
        return $Matches[0];
    }, htmlspecialchars($Html));
    echo '</pre>';
    exit;
}

echo '<ul>';
foreach (glob(__DIR__ . '/test/test.*.php') as $v) {
    $n = substr(basename($v, '.php'), 5);
    echo '<li><a href="?file=' . $n . '" target="_blank">' . $n . '</a>';
}
echo '</ul>';

  ?></body>
</html>