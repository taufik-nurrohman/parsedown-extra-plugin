<?php

$s = <<<S

Lorem ipsum [HTML][1] dolor [API](http://example.com/api) sit [PHP][wow] amet.

Lorem ipsum dolor sit amet. <http://example.com>

[1]: http://example.com/html

S;

$parser->links = array(
    'wow' => array(
        'url' => 'http://example.com/php',
        'title' => 'PHP: Hypertext Preprocessor'
    )
);

$parser->links_attr = array('class' => 'anchor');

echo '<pre style="border:2px solid red;padding:2em;white-space:pre-wrap;" title="input">';
echo htmlentities($s);
echo '</pre>';

$ss = $parser->text($s);

echo '<div style="border:2px solid green;padding:2em;" title="output">';
echo $ss;
echo '</div>';

echo '<pre style="border:2px solid blue;padding:2em;white-space:pre-wrap;" title="html">';
echo htmlentities($ss);
echo '</pre>';