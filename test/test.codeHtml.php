<?php

$Text = <<<S

Lorem ipsum `dolor<br>sit` amet.

Foo bar `baz` qux.

S;

$Parsedown->codeHtml = '<mark>%s</mark>';