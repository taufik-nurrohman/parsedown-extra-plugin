<?php

$Text = <<<S

Lorem ipsum dolor sit amet. [^1] [^2] [^abcdef]

Lorem ipsum dolor sit amet. [^2]

[^1]: Lorem ipsum dolor sit amet.
[^2]: Lorem ipsum dolor sit amet.
[^abcdef]: Lorem ipsum dolor sit amet.

S;

$Parsedown->footnoteLinkHtml = function ($Number, $Attributes, &$Element, $Name, $Index) {
    return $Name . ':nth(' . $Index . ')';
};