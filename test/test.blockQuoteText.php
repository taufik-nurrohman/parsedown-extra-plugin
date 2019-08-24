<?php

$Text = <<<S

### Default Quote

> Lorem ipsum dolor sit amet.

### Danger Quote

> **Danger:** Lorem ipsum dolor sit amet.

### Info Quote

> **Info:** Lorem ipsum dolor sit amet.

S;

$Parsedown->blockQuoteText = '<div markdown="1" style="border: 1px solid;">%s</div>';