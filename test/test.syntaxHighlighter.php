<?php

$Text = <<<S

~~~
for (\$i = 0, \$j = count(\$code); \$i < \$j; ++\$i) {
    yield \$i => '&#' . \$code[\$i] . ';';
}
~~~

~~~
<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta content="width=device-width" name="viewport">
    <meta charset="utf-8">
    <title>Lorem Ipsum</title>
  </head>
  <body>
    <h1>Lorem Ipsum</h1>
    <p>Lorem ipsum dolor sit amet.</p>
  </body>
</html>
~~~

S;

require __DIR__ . '/test.syntaxHighlighter/generic-syntax-highlighter.php';

$Parsedown->blockCodeHtml = function($Html, $Attributes, &$Element) {
    $Element['attributes']['class'] = 'language-html';
    $Element['attributes']['style'] = 'display: block; background: #def; border: 1px solid; padding: .5em .75em;';
    return SH($Html);
};
