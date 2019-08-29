<?php

$Text = <<<S

Lorem ipsum dolor sit amet. [^1] [^2] [^abcdef]

Lorem ipsum dolor sit amet. [^2]

[^1]: Lorem ipsum dolor sit amet.
[^2]: Lorem ipsum dolor sit amet.
[^abcdef]: Lorem ipsum dolor sit amet.

S;

$Parsedown->footnoteLinkAttributes = function($Number, $Attributes, &$Element, $Name) {
    return array('href' => '#reference:' . $Name);
};

$Parsedown->footnoteReferenceAttributes = function($Number, $Attributes, &$Element, $Name, $Index) {
    return array('id' => 'note:' . $Name . '.' . $Index);
};

$Parsedown->footnoteBackLinkAttributes = function($Number, $Attributes, &$Element, $Name, $Index) {
    return array('href' => '#note:' . $Name . '.' . $Index);
};

$Parsedown->footnoteBackReferenceAttributes = function($Number, $Attributes, &$Element, $Name, $Total) {
    return array('id' => 'reference:' . $Name);
};