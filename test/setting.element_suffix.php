<?php

require 'Parsedown.php';
require 'ParsedownExtra.php';
require '../ParsedownExtraPlugin.php';

$s = <<<S

Lorem ipsum dolor sit amet.  
Lorem ipsum dolor sit amet.

---

Lorem ipsum dolor sit amet.  
Lorem ipsum dolor sit amet.

![foo](bar.png)

S;

$parser = new ParsedownExtraPlugin;

echo '<fieldset>';
echo '<legend>HTML5</legend>';
$parser->element_suffix = '>';
echo $parser->text($s);
echo '</fieldset>';

echo '<fieldset>';
echo '<legend>XHTML</legend>';
$parser->element_suffix = '/>';
echo $parser->text($s);
echo '</fieldset>';