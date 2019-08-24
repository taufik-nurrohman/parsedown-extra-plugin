<?php

$Text = <<<S

> Lorem ipsum dolor sit amet.
>
> > Lorem ipsum dolor sit amet.
>
> Lorem ipsum dolor sit amet.

S;

$Parsedown->blockQuoteAttributes = array('class' => 'quote');