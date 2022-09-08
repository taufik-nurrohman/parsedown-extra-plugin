<?php

$Text = <<<S

foo | bar | baz | qux
--- | :-- | :-: | --:
1   | 2   | 3   | 4
5   | 6   | 7   | 8

S;

$Parsedown->tableColumnAttributes = function ($Text, $Attributes, &$Element, $Align) {
    return array(
        'class' => $Align ? 'text-' . $Align : null,
        'style' => null // Remove inline styles
    );
};