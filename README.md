Extension for [Parsedown Extra](https://github.com/erusev/parsedown-extra)
==========================================================================

> Configurable Markdown to HTML converter with Parsedown Extra.

![Parsedown Logo](https://user-images.githubusercontent.com/1669261/109982015-10e2c300-7d34-11eb-93bd-5f103b9d5165.png)


Contents
--------

 - [Usage](#usage)
 - [Features](#features)
 - [Property Aliases as Methods](#property-aliases-as-methods)


Usage
-----

### Manual

Include `ParsedownExtraPlugin.php` just after the `Parsedown.php` and `ParsedownExtra.php` file:

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

### Composer

From the file manager interface, create a `composer.json` file in your project folder, then add this content:

~~~ .json
{
  "minimum-stability": "dev"
}
~~~

From the command line interface, navigate to your project folder then run this command:

~~~ .sh
composer require taufik-nurrohman/parsedown-extra-plugin
~~~

From the file manager interface, create an `index.php` file in your project folder then require the auto-loader file:

~~~ .php
require 'vendor/autoload.php';

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
$Parsedown->abbreviationData = [
    'CSS' => 'Cascading Style Sheet',
    'HTML' => 'Hyper Text Markup Language',
    'JS' => 'JavaScript'
];
~~~

### Predefined Reference Links and Images

~~~ .php
$Parsedown->referenceData = [
    'mecha-cms' => [
        'url' => 'https://mecha-cms.com',
        'title' => 'Mecha CMS'
    ],
    'test-image' => [
        'url' => 'http://example.com/favicon.ico',
        'title' => 'Test Image'
    ]
);
~~~

### Automatic `rel="nofollow"` Attribute on External Links

~~~ .php
$Parsedown->linkAttributes = function($Text, $Attributes, &$Element, $Internal) {
    if (!$Internal) {
        return [
            'rel' => 'nofollow',
            'target' => '_blank';
        ];
    }
    return [];
};
~~~

### Automatic `id` Attribute on Headers

~~~ .php
$Parsedown->headerAttributes = function($Text, $Attributes, &$Element, $Level) {
    $Id = $Attributes['id'] ?? trim(preg_replace('/[^a-z\d\x{4e00}-\x{9fa5}]+/u', '-', strtolower($Text)), '-');
    return ['id' => $Id];
};
~~~

### Automatic Figure Elements

Every image markup that appears alone in a paragraph will be converted into a figure element automatically.

~~~ .php
$Parsedown->figuresEnabled = true;
$Parsedown->figureAttributes = ['class' => 'image'];

$Parsedown->imageAttributesOnParent = ['class', 'id'];
~~~

To add a caption below the image, prepend at least one space but less than four spaces to turn the paragraph sequence that comes after the image into an image caption.

~~~ .markdown
This is a paragraph.

![Image](/path/to/image.jpg)
 Image caption.

This is a paragraph.

![Image](/path/to/image.jpg)

 Image caption in a paragraph tag.

This is a paragraph.

![Image](/path/to/image.jpg)

    This is a code block.

This is a paragraph.
~~~

FYI, this format is also valid for average Markdown files. And so, it will degraded gracefully when parsed by other Markdown converters.

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
// <https://github.com/scrivo/highlight.php>
function doApplyHighlighter(string $Text, array $ClassList, &$Element) {
    $Highlight = new \Highlight\Highlighter;
    $Highlight->setAutodetectLanguages($ClassList);
    $Highlighted = $Highlight->highlightAuto($Text);
    $Element['attributes']['class'] = 'hljs ' . $Highlighted->language;
    return $Highlighted->value;
}

$Parsedown->codeHtml = function($Text, $Attributes, &$Element) {
    return doApplyHighlighter($Text, [], $Element);
};

$Parsedown->blockCodeHtml = function($Text, $Attributes, &$Element) {
    $ClassList = array_filter(explode(' ', $Attributes['class'] ?? ""));
    return doApplyHighlighter($Text, $ClassList, $Element);
};
~~~

### Put `<code>` Attributes on `<pre>` Element

~~~ .php
$Parsedown->codeAttributesOnParent = true;
~~~

### Custom Quote Block Class

~~~ .php
$Parsedown->blockQuoteAttributes = ['class' => 'quote'];
~~~

~~~ .php
$Parsedown->blockQuoteAttributes = function($Text, $Attributes, &$Element) {
    if (strpos($Text, '**Danger:** ') === 0) {
        return ['class' => 'alert alert-danger'];
    }
    if (strpos($Text, '**Info:** ') === 0) {
        return ['class' => 'alert alert-info'];
    }
    return [];
};
~~~

### Custom Table Attributes

~~~ .php
$Parsedown->tableAttributes = ['border' => 1];
~~~

### Custom Table Alignment Class

~~~ .php
$Parsedown->tableColumnAttributes = function($Text, $Attributes, &$Element, $Align) {
    return [
        'class' => $Align ? 'text-' . $Align : null,
        'style' => null // Remove inline styles
    ];
};
~~~

### Custom Footnote ID Format

~~~ .php
$Parsedown->footnoteLinkAttributes = function($Number, $Attributes, &$Element, $Name) {
    return ['href' => '#to:' . $Name];
};

$Parsedown->footnoteReferenceAttributes = function($Number, $Attributes, &$Element, $Name, $Index) {
    return ['id' => 'from:' . $Name . '.' . $Index];
};

$Parsedown->footnoteBackLinkAttributes = function($Number, $Attributes, &$Element, $Name, $Index) {
    return ['href' => '#from:' . $Name . '.' . $Index];
};

$Parsedown->footnoteBackReferenceAttributes = function($Number, $Attributes, &$Element, $Name, $Total) {
    return ['id' => 'to:' . $Name];
};
~~~

### Custom Footnote Class

~~~ .php
$Parsedown->footnoteAttributes = ['class' => 'notes'];
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
 - `{.php #foo}` → `<pre><code class="php" id="foo">`


Property Aliases as Methods
---------------------------

Property aliases are available as methods just to follow the way **Parsedown** set its configuration data. It uses PHP `__call` method to generate the class methods automatically:

~~~ .php
// This is ...
$Parsedown->setBlockCodeHtml(function() { ... });

// ... equal to this
$Parsedown->blockCodeHtml = function() { ... };
~~~
