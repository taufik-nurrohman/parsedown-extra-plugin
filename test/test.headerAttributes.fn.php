<?php

$Text = <<<S

Header 1
========

Header 2
--------

# Header 1 {#foo}

## Header 2 {#bar}

### Header 3

#### Header 4

##### Header 5

###### Header 6

####### Paragraph

S;

$Parsedown->headerAttributes = function($Text, $Attributes, $Element, $Level) {
    if (isset($Attributes['id'])) {
        $Id = $Attributes['id'];
    } else {
        $Id = trim(preg_replace('/[^a-z\d]+/', '-', strtolower($Text)), '-');
    }
    return array(
        'class' => 'header-' . $Level,
        'id' => $Id
    );
};