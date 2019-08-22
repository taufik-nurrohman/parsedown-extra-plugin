<?php

$s = <<<S

~~~
<p>Lorem ipsum dolor sit amet.</p>
~~~

```
<p>Lorem ipsum dolor sit amet.</p>
```

~~~ html
<p>Lorem ipsum dolor sit amet.</p>
~~~

``` html
<p>Lorem ipsum dolor sit amet.</p>
```

~~~ html php
<p>Lorem ipsum dolor sit amet.</p>
~~~

``` html php
<p>Lorem ipsum dolor sit amet.</p>
```

~~~ html.php
<p>Lorem ipsum dolor sit amet.</p>
~~~

``` html.php
<p>Lorem ipsum dolor sit amet.</p>
```

~~~ html .php
<p>Lorem ipsum dolor sit amet.</p>
~~~

``` html .php
<p>Lorem ipsum dolor sit amet.</p>
```

S;

$parser->blockCodeHtml = '<mark>%s</mark>';

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