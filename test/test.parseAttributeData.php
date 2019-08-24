<?php

$Text = <<<S

Lorem ipsum dolor [sit](foo) {.foo.bar#baz#qux} amet.

Lorem ipsum dolor [sit](foo) {#foo:bar .baz:qux} amet.

Lorem ipsum dolor [sit](foo) {a} amet.

Lorem ipsum dolor [sit](foo) {a=b} amet.

Lorem ipsum dolor [sit](foo) {a=} amet.

Lorem ipsum dolor [sit](foo) {a="b"} amet.

Lorem ipsum dolor [sit](foo) {a=""} amet.

Lorem ipsum dolor [sit](foo) {a='b'} amet.

Lorem ipsum dolor [sit](foo) {a=''} amet.

---

Lorem ipsum dolor [sit](foo) {a="b" c=d e f="" g= h} amet.

Lorem ipsum dolor [sit](foo) {a="b\"b\'b" b='c\'c\"c' c=d e f="" g= h} amet.

---

Lorem ipsum dolor [_sit_](foo) {target="_blank"} amet.

Lorem ipsum dolor [_sit_](foo) {target='_blank'} amet.

Lorem ipsum dolor [_sit_](foo) {target=_blank} amet.

Lorem ipsum dolor [*sit*](foo) {foo="*bar"} amet.

Lorem ipsum dolor [*sit*](foo) {foo='*bar'} amet.

Lorem ipsum dolor [*sit*](foo) {foo=*bar} amet.

### Issue #4

Lorem ipsum dolor _[sit](foo) {target="_blank"}_ amet.

Lorem ipsum dolor _[sit](foo) {target='_blank'}_ amet.

Lorem ipsum dolor _[sit](foo) {target=_blank}_ amet.

Lorem ipsum dolor *[sit](foo) {foo="*bar"}* amet.

Lorem ipsum dolor *[sit](foo) {foo='*bar'}* amet.

Lorem ipsum dolor *[sit](foo) {foo=*bar}* amet.

S;
