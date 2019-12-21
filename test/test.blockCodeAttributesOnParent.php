<?php

$Text = <<<S

~~~
Lorem ipsum dolor sit amet.
~~~

```
Lorem ipsum dolor sit amet.
```

~~~ markdown
Lorem ipsum dolor sit amet.
~~~

``` markdown
Lorem ipsum dolor sit amet.
```

S;

$Parsedown->blockCodeAttributesOnParent = true;