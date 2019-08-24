<?php

$Text = <<<S

Lorem ipsum ![HTML Image][1] dolor ![API Image](http://example.com/api.jpg) sit ![PHP Image][wow] amet.

[1]: http://example.com/html.jpg

S;

$Parsedown->referenceData = array(
    'wow' => array(
        'url' => 'http://example.com/php.jpg',
        'title' => 'PHP: Hypertext Preprocessor'
    )
);

$Parsedown->imageAttributes = function($Text, $Attributes, $Element, $Internal) {
    $Any = array('class' => $Internal ? 'local-image' : 'remote-image');
    if (isset($Attributes['title'])) {
        $Any['width'] = 75;
        $Any['height'] = 75;
    }
    return $Any;
};