<?php

$Text = <<<S

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

$Parsedown->blockCodeHtml = function($Text, $Attributes, &$Element) {
    if (empty($Attributes['class'])) {
        return '<mark>' . $Text . '</mark>';
    } else {
        $Element['attributes']['class'] .= ' test';
    }
    return $Text;
};