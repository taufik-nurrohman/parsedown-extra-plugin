<?php

$s = <<<S

Lorem ipsum `dolor` sit amet.

    Lorem ipsum dolor sit amet.
    Lorem ipsum dolor sit amet.
    Lorem ipsum dolor sit amet.

~~~
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
~~~

```
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
```

~~~ markdown
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
~~~

``` markdown
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
```

S;

$parser->code_text = function($text) {
    return strtoupper($text);
};

$parser->code_block_text = function($text) {
    // fake line number(s)
    $a = explode("\n", $text);
    foreach ($a as $k => &$v) {
        $v = ($k + 1) . '. ' . $v;
    }
    return implode("\n", $a);
};

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