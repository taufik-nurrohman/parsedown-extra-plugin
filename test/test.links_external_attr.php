<?php

$s = <<<S

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

 - [foo](http://localhost/a)
 - [bar](http://localhost/a?bar)
 - [baz](http://localhost/a&qux)
 - [qux](http://localhost/a#yo)

---

 - [foo](//localhost/a)
 - [bar](//localhost/a?bar)
 - [baz](//localhost/a&qux)
 - [qux](//localhost/a#yo)
 
---
 
 - [javascript](javascript:void(0))

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

$parser->links_external_attr = array(
    'rel' => 'nofollow',
    'target' => '_blank'
);

echo '<pre style="border:2px solid red;padding:2em;white-space:pre-wrap;" title="input">';
echo $s;
echo '</pre>';

$ss = $parser->text($s);

echo '<div style="border:2px solid green;padding:2em;" title="output">';
echo $ss;
echo '</div>';

echo '<pre style="border:2px solid blue;padding:2em;white-space:pre-wrap;" title="html">';
echo htmlentities($ss);
echo '</pre>';