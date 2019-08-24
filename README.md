Extension for [Parsedown Extra](https://github.com/erusev/parsedown-extra)
==========================================================================

> Configurable Markdown to HTML converter with Parsedown Extra.


<!-- ![Parsedown](https://i.imgur.com/yE8afYV.png) -->

<p align="center"><img alt="Parsedown" src="https://i.imgur.com/fKVY6Kz.png" width="240" /></p>


Contents
--------

 - [Usage](#usage)
 - [Features](#features)
 - [Property Aliases as Methods](#property-aliases-as-methods)


Usage
-----

Include `ParsedownExtraPlugin.php` just after the `Parsedown.php` and `ParsedownExtra.php`:

~~~ .php
require 'Parsedown.php';
require 'ParsedownExtra.php';
require 'ParsedownExtraPlugin.php';

# Create
$Parsedown = new ParsedownExtraPlugin;

# Configure
$Parsedown->voidElementSuffix = '>'; // HTML5

# Use
echo $Parsedown->text('# Header {.sth}');
~~~


Features
--------

### HTML or XHTML

~~~ .php
$Parsedown->voidElementSuffix = '>'; // HTML5
~~~

### Predefined Abbreviations

~~~ .php
$Parsedown->abbreviationData = array(
    'CSS' => 'Cascading Style Sheet',
    'HTML' => 'Hyper Text Markup Language',
    'JS' => 'JavaScript'
);
~~~

### Predefined Reference Links and Images

~~~ .php
$Parsedown->referenceData = array(
    'mecha-cms' => array(
        'url' => 'http://mecha-cms.com',
        'title' => 'Mecha CMS'
    ),
    'test-image' => array(
        'url' => 'http://example.com/favicon.ico',
        'title' => 'Test Image'
    )
);
~~~

### Automatic `rel="nofollow"` Attribute on External Links

~~~ .php
$Parsedown->linkAttributes = function($Text, $Attributes, $Element, $Internal) {
    if (!$Internal) {
        return array(
            'rel' => 'nofollow',
            'target' => '_blank';
        );
    }
    return array();
};
~~~

### Automatic `id` Attributes on Headers

~~~ .php
$Parsedown->headerAttributes = function($Text, $Attributes, $Element, $Level) {
    if (isset($Attributes['id'])) {
        $Id = $Attributes['id'];
    } else {
        $Id = trim(preg_replace('/[^a-z\d]+/', '-', strtolower($Text)), '-');
    }
    return array('id' => $Id);
};
~~~

~~~ .php
$Parsedown->linkAttributes = function($Text, $Attributes, $Element, $Internal) {
    if (!$Internal) {
        return array(
            'rel' => 'nofollow',
            'target' => '_blank';
        );
    }
    return array();
};
~~~

### Custom Code Block Class Format

~~~ .php
$Parsedown->blockCodeClassFormat = 'language-%s';
~~~

### Custom Code Block Contents

~~~ .php
$Parsedown->codeHtml = '<span class="my-code">%s</span>';
$Parsedown->blockCodeHtml = '<span class="my-code-block">%s</span>';
~~~

~~~ .php
function doApplySyntaxHighlighter($Html, array $ClassList) { ... }

$Parsedown->codeHtml = function($Html, $Attributes, $Element) {
    return doApplySyntaxHighlighter($Html, array());
};

$Parsedown->blockCodeHtml = function($Html, $Attributes, $Element) {
    $ClassList = isset($Attributes['class']) ? explode(' ', $Attributes['class']) : array();
    return doApplySyntaxHighlighter($Html, $ClassList);
};
~~~

### Put `<code>` Attributes on `<pre>` Element

~~~ .php
$Parsedown->blockCodeAttributesOnParent = true;
~~~

### Custom Quote Block Class

~~~ .php
$Parsedown->blockQuoteAttributes = array('class' => 'quote');
~~~

~~~ .php
$Parsedown->blockQuoteAttributes = function($Text, $Attributes, $Element) {
    if (strpos($Text, '**Danger:** ') === 0) {
        return array('class' => 'alert alert-danger');
    }
    if (strpos($Text, '**Info:** ') === 0) {
        return array('class' => 'alert alert-info');
    }
    return array();
};
~~~

### Custom Table Class

~~~ .php
$Parsedown->tableAttributes = array('class' => 'table-bordered');
~~~

### Custom Table Alignment Class

~~~ .php
$Parsedown->tableColumnAttributes = function($Text, $Attributes, $Element, $Align) {
    return array(
        'class' => $Align ? 'text-' . $Align : null,
        'style' => null // Remove inline styles
    );
};
~~~

### Custom Footnote ID Format

~~~ .php
$Parsedown->footnoteLinkAttributes = function($Number, $Attributes, $Element, $Name) {
    return array('href' => '#reference:' . $Name);
};

$Parsedown->footnoteReferenceAttributes = function($Number, $Attributes, $Element, $Name, $Index) {
    return array('id' => 'note:' . $Name . '.' . $Index);
};

$Parsedown->footnoteBackLinkAttributes = function($Number, $Attributes, $Element, $Name, $Index) {
    return array('href' => '#note:' . $Name . '.' . $Index);
};

$Parsedown->footnoteBackReferenceAttributes = function($Number, $Attributes, $Element, $Name, $Total) {
    return array('id' => 'reference:' . $Name);
};
~~~

### Custom Footnote Class

~~~ .php
$Parsedown->footnoteAttributes = array('class' => 'notes');
~~~

### Custom Footnote Link Text

~~~ .php
$Parsedown->footnoteLinkHtml = '[%s]';
~~~

### Custom Footnote Back Link Text

~~~ .php
$Parsedown->footnoteBackLinkHtml = '<i class="icon icon-back"></i>';
~~~

### Advance Attribute Parser

 - `{#foo}` → `<tag id="foo">`
 - `{#foo#bar}` → `<tag id="bar">`
 - `{.foo}` → `<tag class="foo">`
 - `{.foo.bar}` → `<tag class="foo bar">`
 - `{#foo.bar.baz}` → `<tag id="foo" class="bar baz">`
 - `{#foo .bar .baz}` → `<tag id="foo" class="bar baz">` (white-space before `#` and `.` becomes optional in my extension)
 - `{foo="bar"}` → `<tag foo="bar">`
 - `{foo="bar baz"}` → `<tag foo="bar baz">`
 - `{foo='bar'}` → `<tag foo="bar">`
 - `{foo='bar baz'}` → `<tag foo="bar baz">`
 - `{foo=bar}` → `<tag foo="bar">`
 - `{foo=}` → `<tag foo="">`
 - `{foo}` → `<tag foo="foo">`
 - `{foo=bar baz}` → `<tag foo="bar" baz="baz">`
 - `{#a#b.c.d e="f" g="h i" j='k' l='m n' o=p q= r s t="u#v.w.x y=z"}` → `<tag id="b" class="c d" e="f" g="h i" j="k" l="m n" o="p" q="" r="r" s="s" t="u#v.w.x y=z">`

### Code Block Class Without `language-` Prefix

Dot prefix in class name are now becomes optional, custom attributes syntax also acceptable:

 - `php` → `<pre><code class="language-php">`
 - `php html` → `<pre><code class="language-php language-html">`
 - `.php` → `<pre><code class="php">`
 - `.php.html` → `<pre><code class="php html">`
 - `.php html` → `<pre><code class="php language-html">`
 - `{.php #foo}` → `<pre><code id="foo" class="php">`


Property Aliases as Methods
---------------------------

Property aliases are available as methods just to follow the way `Parsedown` set its configuration data. It uses PHP `__call` method to generate the class methods automatically:

~~~ .php
// This is ...
$Parsedown->setBlockCodeHtml(function() { ... });

// ... equal to this
$Parsedown->blockCodeHtml = function() { ... };
~~~