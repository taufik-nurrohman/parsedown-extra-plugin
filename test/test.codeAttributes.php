<?php

$Text = <<<S

Lorem ipsum `dolor` sit amet.

Foo bar `baz` qux.

S;

$Parsedown->codeAttributes = array('class' => 'code');