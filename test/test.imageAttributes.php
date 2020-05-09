<?php

$Text = <<<S

Lorem ipsum ![HTML Image][1] dolor ![API Image](https://via.placeholder.com/125x125) sit ![PHP Image][wow] amet.

[1]: https://via.placeholder.com/125x125

S;

$Parsedown->referenceData = array(
    'wow' => array(
        'url' => 'https://via.placeholder.com/125x125/333333/888888',
        'title' => 'PHP: Hypertext Preprocessor'
    )
);

$Parsedown->imageAttributes = array('loading' => 'lazy');
