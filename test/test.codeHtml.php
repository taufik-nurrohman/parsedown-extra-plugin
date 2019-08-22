<?php

$s = <<<S

Lorem ipsum `dolor<br>sit` amet.

Foo bar `baz` qux.

S;

$parser->codeHtml = '<mark>%s</mark>';

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