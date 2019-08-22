<?php

$s = <<<S

Lorem ipsum ![HTML Image][1] dolor ![API Image](http://example.com/api.jpg) sit ![PHP Image][wow] amet.

[1]: http://example.com/html.jpg

S;

$parser->referenceData = array(
    'wow' => array(
        'url' => 'http://example.com/php.jpg',
        'title' => 'PHP: Hypertext Preprocessor'
    )
);

$parser->imageAttributes = array('loading' => 'lazy');

echo '<pre style="border:2px solid red;padding:2em;white-space:pre-wrap;" title="input">';
echo htmlspecialchars($s);
echo '</pre>';

$ss = $parser->text($s);

echo '<div style="border:2px solid green;padding:2em;" title="output">';
echo $ss;
echo '</div>';

echo '<pre style="border:2px solid blue;padding:2em;white-space:pre-wrap;" title="html">';
echo htmlspecialchars($ss);
echo '</pre>';