<?php

$Text = <<<S

Lorem ipsum [HTML][1] dolor [API](http://example.com/api) sit [PHP][wow] amet.

Lorem ipsum dolor sit amet. <http://example.com>

Lorem ipsum dolor sit amet. http://example.com

[1]: http://example.com/html

S;

$Parsedown->referenceData = array(
    'wow' => array(
        'url' => 'http://example.com/php',
        'title' => 'PHP: Hypertext Preprocessor'
    )
);

$Parsedown->linkAttributes = array('class' => 'anchor');