<?php

$s = <<<S

Lorem ipsum HTML dolor API sit PHP amet.

*[HTML]: Hyper Text Markup Language
*[PHP]:

S;

$parser->abbreviations = array('API' => 'Application Programming Interface');

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