<?php

$Text = <<<S

Lorem ipsum dolor sit amet. [^1] [^2] [^abcdef]

Lorem ipsum dolor sit amet. [^2]

[^1]: Lorem ipsum dolor sit amet.
[^2]: Lorem ipsum dolor sit amet.
[^abcdef]: Lorem ipsum dolor sit amet.

S;

$Parsedown->footnoteBackLinkAttributes = function ($Number, $Attributes, &$Element, $Name, $Index) {
    return array(
        'data-name' => $Name,
        'data-index' => $Index
    );
};

$Parsedown->footnoteBackReferenceAttributes = function ($Number, $Attributes, &$Element, $Name, $Total) {
    return array(
        'data-name' => $Name,
        'data-total' => $Total
    );
};