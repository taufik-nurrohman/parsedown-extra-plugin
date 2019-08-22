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

$parser->linkAttributes = function($Attributes) {
    if (isset($Attributes['href'])) {
        if (ParsedownExtraPlugin::isExternalLink($Attributes['href'])) {
            return array(
                'rel' => 'nofollow',
                'target' => '_blank'
            );
        }
    }
};

echo '<pre style="border:2px solid red;padding:2em;white-space:pre-wrap;" title="input">';
echo $s;
echo '</pre>';

$ss = $parser->text($s);

echo '<div style="border:2px solid green;padding:2em;" title="output">';
echo $ss;
echo '</div>';

echo '<pre style="border:2px solid blue;padding:2em;white-space:pre-wrap;" title="html">';
echo htmlspecialchars($ss);
echo '</pre>';