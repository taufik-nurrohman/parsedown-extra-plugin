<?php

$s = <<<S

Page Title
----------

Page content.

 - List item 1
 - List item 2
 - List item 3

---

Lorem ipsum dolor sit amet. [^1]

[^1]: Foo bar baz qux.

S;

$parser->voidElementSuffix = '>';

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