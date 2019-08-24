<?php

$Text = <<<S

Lorem ipsum dolor sit amet. [^1] [^2] [^abcdef]

Lorem ipsum dolor sit amet. [^2]

[^1]: Lorem ipsum dolor sit amet.
[^2]: Lorem ipsum dolor sit amet.
[^abcdef]: Lorem ipsum dolor sit amet.

S;

$Parsedown->footnoteLinkAttributes = function($Number, $Attributes, $Element, $Name, $Index) {
    return array(
        'data-name' => $Name,
        'data-index' => $Index,
        'data-number' => $Number
    );
};

$Parsedown->footnoteReferenceAttributes = function($Number, $Attributes, $Element, $Name, $Index) {
    return array(
        'data-name' => $Name,
        'data-index' => $Index,
        'data-number' => $Number
    );
};