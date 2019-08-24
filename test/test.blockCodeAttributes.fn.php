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

S;

$Parsedown->blockCodeAttributes = function($Text, $Attributes) {
    if (isset($Attributes['class']) && $Attributes['class'] === 'language-html') {
        return array('title' => 'Code Block');
    }
};