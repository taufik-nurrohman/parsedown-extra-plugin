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

### Issue #15

Lorem ipsum dolor [sit](/) {#foo.bar.baz class="asdf hjkl"} amet.

Lorem ipsum dolor [sit](/) {#foo.bar.baz class='asdf hjkl'} amet.

Lorem ipsum dolor [sit](/) {#foo.bar.baz class="asdf"} amet.

Lorem ipsum dolor [sit](/) {#foo.bar.baz class='asdf'} amet.

Lorem ipsum dolor [sit](/) {#foo.bar.baz class=asdf} amet.

Lorem ipsum dolor [sit](/) {#foo.bar.baz class=} amet.

Lorem ipsum dolor [sit](/) {#foo.bar.baz class} amet.

Lorem ipsum dolor [sit](/) {id class} amet.

Lorem ipsum dolor [sit](/) {#foo.bar id='baz' class='qux'} amet.

S;
