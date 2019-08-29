<?php

$Text = <<<S

### Internal

 - [foo](/)
 - [bar](?bar)
 - [baz](&qux)
 - [qux](#yo)

---

 - [foo](a)
 - [foo](/a)
 - [bar](a?bar)
 - [baz](a&qux)
 - [qux](a#yo)

---

 - [foo](http://127.0.0.1/a)
 - [bar](http://127.0.0.1/a?bar)
 - [baz](http://127.0.0.1/a&qux)
 - [qux](http://127.0.0.1/a#yo)

---

 - [foo](//127.0.0.1/a)
 - [bar](//127.0.0.1/a?bar)
 - [baz](//127.0.0.1/a&qux)
 - [qux](//127.0.0.1/a#yo)
 
---

 - [javascript](javascript:void(0))
 - [data:text/html](data:text/html,<foo>bar</foo>)
 - [data:text/base64](data:text/base64,asdf)

### External

 - [foo](http://example.com)
 - [bar](http://example.com?bar)
 - [baz](http://example.com&qux)
 - [qux](http://example.com#yo)

---

 - [foo](//example.com)
 - [bar](//example.com?bar)
 - [baz](//example.com&qux)
 - [qux](//example.com#yo)

---

 - [foo](http://example.com/a)
 - [bar](http://example.com/a?bar)
 - [baz](http://example.com/a&qux)
 - [qux](http://example.com/a#yo)

S;

$Parsedown->linkAttributes = function($Text, $Attributes, &$Element, $Internal) {
    if (isset($Attributes['href'])) {
        if (!$Internal) {
            return array(
                'rel' => 'nofollow',
                'target' => '_blank'
            );
        }
    }
};