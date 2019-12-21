<?php

$Text = <<<S

Lorem ipsum [HTML][1] dolor [API][2] sit [PHP][wow] amet.

[1]: http://example.com/html

S;

$Parsedown->referenceData = array(
    '2' => array(
        'url' => 'http://example.com/api',
        'title' => 'Application Programming Interface'
    ),
    'wow' => array(
        'url' => 'http://example.com/php',
        'title' => 'PHP: Hypertext Preprocessor'
    )
);