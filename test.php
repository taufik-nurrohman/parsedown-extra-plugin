<?php

if (isset($_GET['file']) && file_exists(__DIR__ . '/test/test.' . $_GET['file'] . '.php')) {
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