<?php

$s = <<<S

### Breaks Enabled

foo
bar
baz
qux

### Default Breaks Control

foo  
bar  
baz  
qux

S;

$parser->setBreaksEnabled(true);

echo '<pre style="border:2px solid red;padding:2em;white-space:pre-wrap;" title="input">';
echo htmlspecialchars($s);
echo '</pre>';

$ss = $parser->text($s);

echo '<div style="border:2px solid green;padding:2em;" title="output">';
echo $ss;
echo '</div>';

echo '<pre style="border:2px solid blue;padding:2em;white-space:pre-wrap;" title="html">';
echo htmlspecialchars($ss);
echo '</pre>';