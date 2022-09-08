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

$Parsedown->headerText = function ($Text, $Attributes, &$Element, $Level) {
    if (isset($Attributes['id'])) {
        $Id = $Attributes['id'];
    } else {
        $Id = trim(preg_replace('/[^a-z\d\x{4e00}-\x{9fa5}]+/u', '-', strtolower($Text)), '-');
    }
    $Element['attributes']['id'] = $Id;
    return '[#](#' . $Id . ') {.hover-visible} ' . $Text;
};

echo <<<S
<style>
h1, h2, h3, h4, h5, h6 {
  position: relative;
}
.hover-visible {
  position: absolute;
  top: 0;
  right: 100%;
  padding-right: .25em;
  visibility: hidden;
}
h1:hover .hover-visible,
h2:hover .hover-visible,
h3:hover .hover-visible,
h4:hover .hover-visible,
h5:hover .hover-visible,
h6:hover .hover-visible {
  visibility: visible;
}
</style>
S;
