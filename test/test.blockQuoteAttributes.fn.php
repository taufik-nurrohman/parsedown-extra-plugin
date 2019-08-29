<?php

$Text = <<<S

### Default Quote

> Lorem ipsum dolor sit amet.

### Danger Quote

> **Danger:** Lorem ipsum dolor sit amet.

### Info Quote

> **Info:** Lorem ipsum dolor sit amet.

S;

$Parsedown->blockQuoteAttributes = function($Text, $Attributes, &$Element) {
    if (strpos($Text, '**Danger:** ') === 0) {
        return array('class' => 'alert alert-danger');
    }
    if (strpos($Text, '**Info:** ') === 0) {
        return array('class' => 'alert alert-info');
    }
};

echo <<<S

<style>
blockquote {
  border-left: 5px solid;
  padding: 0 0 0 1em;
  margin: 0;
}
.alert-danger {
  color: red;
}
.alert-info {
  color: blue;
}
</style>

S;
