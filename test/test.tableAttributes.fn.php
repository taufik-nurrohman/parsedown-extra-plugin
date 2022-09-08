<?php

$Text = <<<S

foo | bar | baz
--- | --- | ---
1   | 2   | 3
4   | 5   | 6
7   | 8   | 9

S;

$Parsedown->tableAttributes = function ($Text, $Attributes, &$Element) {
    // thead > tr > *
    $numberOfColumns = count($Element['elements'][0]['elements'][0]['elements']);
    // tbody > *
    $numberOfRows = count($Element['elements'][1]['elements']) + 1; // Plus the table header
    return array(
        'border' => 1,
        'class' => 'has-' . $numberOfColumns . '-columns has-' . $numberOfRows . '-rows'
    );
};