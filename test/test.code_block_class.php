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

~~~ foo .bar
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
~~~

``` .foo bar
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
```

~~~ {#foo.bar}
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
~~~

``` {.foo#bar}
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet.
```

S;

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