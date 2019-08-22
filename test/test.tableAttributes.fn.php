<?php

$s = <<<S

foo | bar | baz
--- | --- | ---
1   | 2   | 3
4   | 5   | 6
7   | 8   | 9

S;

$parser->tableAttributes = function($Attributes, $Element) {
    // thead > tr > *
    $numberOfColumns = count($Element['elements'][0]['elements'][0]['elements']);
    // tbody > *
    $numberOfRows = count($Element['elements'][1]['elements']) + 1; // Plus the table header
    return array(
        'border' => 1,
        'class' => 'has-' . $numberOfColumns . '-columns has-' . $numberOfRows . '-rows'
    );
};

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