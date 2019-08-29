<?php

$Text = <<<S

Lorem ipsum `dolor<br>sit` amet.

Foo bar `baz` qux.

S;

$Parsedown->codeHtml = function($Text, $Attributes, &$Element) {
    if (strpos($Text, '&lt;') !== false) {
        return '<mark>' . $Text . '</mark>';
    }
    return $Text;
};