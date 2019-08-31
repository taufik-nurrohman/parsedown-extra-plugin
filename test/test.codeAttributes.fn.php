<?php

$Text = <<<S

Lorem ipsum `dolor` sit amet.

Foo bar `baz` qux.

S;

$Parsedown->codeAttributes = function($Html, $Attributes, &$Element) {
    if ($Html === 'baz') {
        return array('class' => 'code-baz');
    }
};