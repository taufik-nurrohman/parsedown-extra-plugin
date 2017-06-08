<?php

$s = <<<S

foo | bar | baz | qux
---:|:---:|:--- | ---
1   | 2   | 3   | 4
5   | 6   | 7   | 8

S;

$parser->table_align_class = 'aligned align-%s';

echo '<pre style="border:2px solid red;padding:2em;white-space:pre-wrap;" title="input">';
echo htmlentities($s);
echo '</pre>';

$ss = $parser->text($s);

echo '<div style="border:2px solid green;padding:2em;" title="output">';
echo $ss;
echo '</div>';

echo '<pre style="border:2px solid blue;padding:2em;white-space:pre-wrap;" title="html">';
echo htmlentities($ss);
echo '</pre>';