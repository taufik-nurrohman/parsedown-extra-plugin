<?php

$Text = <<<S

foo | bar | baz | qux
--- | :-- | :-: | --:
1   | 2   | 3   | 4
5   | 6   | 7   | 8

S;

$Parsedown->tableColumnAttributes = array('title' => 'Table Column');