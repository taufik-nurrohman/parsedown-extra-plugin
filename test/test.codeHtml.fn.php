<?php

$Text = <<<S

Lorem ipsum `dolor<br>sit` amet.

Foo bar `baz` qux.

S;

$Parsedown->codeHtml = function($Html, $Attributes, &$Element) {
    if (strpos($Html, '&lt;') !== false) {
        return '<mark>' . $Html . '</mark>';
    }
    return $Html;
};