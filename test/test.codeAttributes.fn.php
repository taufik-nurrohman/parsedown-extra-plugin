<?php

$Text = <<<S

Lorem ipsum `dolor` sit amet.

Foo bar `baz` qux.

S;

$Parsedown->codeAttributes = function($Text, $Attributes, &$Element) {
    if ($Text === 'baz') {
        return array('class' => 'code-baz');
    }
};
