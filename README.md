Extension for [Parsedown Extra](https://github.com/erusev/parsedown-extra)
==========================================================================

> Configurable Markdown to HTML converter with Parsedown Extra.


Table of Content
----------------

- [1. Installation](#installation)
- [2. Features](#features)
  - [HTML or XHTML](#html-or-xhtml)
  - [Predefined Abbreviations](#predefined-links)
  - [Predefined Links](#predefined-links)
  - [Automatic `rel="nofollow"` Attribute on External Links](#automatic-relnofollow-attribute-on-external-links)
  - [Custom Code Class Format](#custom-code-class-format)
  - [Custom Code Text Format](#custom-code-text-format)
  - [Put `<code>` Attributes on `<pre>` Element](#put-code-attributes-on-pre-element)
  - [Custom Table Class](#custom-table-class)
  - [Custom Table Alignment Class](#custom-table-alignment-class)
  - [Custom Footnote ID Format](#custom-footnote-id-format)
  - [Custom Footnote Back ID Format](#custom-footnote-back-id-format)
  - [Custom Footnote Class](#custom-footnote-class)
  - [Custom Footnote Link Class](#custom-footnote-link-class)
  - [Custom Footnote Back Link Class](#custom-footnote-back-link-class)
  - [Custom Footnote Link Text](#custom-footnote-link-text)
  - [Custom Footnote Back Link Text](#custom-footnote-back-link-text)
  - [Advance Attribute Parser](#advance-attribute-parser)
  - [Code Block Class Without `language-` Prefix](#code-block-class-without-language--prefix)


Installation
------------

Include `ParsedownExtraPlugin.php` just after the `Parsedown.php` and `ParsedownExtra.php`:

~~~ .php
require 'Parsedown.php';
require 'ParsedownExtra.php';
require 'ParsedownExtraPlugin.php';

$parser = new ParsedownExtraPlugin();

// settings ...
$parser->code_class = 'lang-%s';

echo $parser->text('# Header {.sth}');
~~~


Features
--------

### HTML or XHTML

~~~ .php
$parser->element_suffix = '>'; // HTML5
~~~

### Predefined Abbreviations

~~~ .php
$parser->abbreviations = array(
    'CSS' => 'Cascading Style Sheet',
    'HTML' => 'Hyper Text Markup Language',
    'JS' => 'JavaScript'
);
~~~

### Predefined Links

~~~ .php
$parser->links = array(
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
// custom link attributes
$parser->links_attr = array();

// custom external link attributes
$parser->links_external_attr = array(
    'rel' => 'nofollow',
    'target' => '_blank'
);

// custom image attributes
$parser->images_attr = array(
    'alt' => ""
);

// custom external image attributes
$parser->images_external_attr = array();
~~~

### Custom Code Class Format

~~~ .php
$parser->code_class = 'language-%s';
~~~

~~~ .php
$parser->code_class = function($text) {
    return trim(str_replace('.', ' ', $text));
};
~~~

### Custom Code Text Format

~~~ .php
$parser->code_text = '<span class="my-code">%s</span>';
$parser->code_block_text = '<span class="my-code-block">%s</span>';
~~~

~~~ .php
$parser->code_text = function($text) {
    return do_syntax_highlighter($text);
};

$parser->code_block_text = function($text) {
    return do_syntax_highlighter($text);
};
~~~

### Put `<code>` Attributes on `<pre>` Element

~~~ .php
$parser->code_block_attr_on_parent = true;
~~~

### Custom Table Class

~~~ .php
$parser->table_class = 'table-bordered';
~~~

### Custom Table Alignment Class

~~~ .php
$parser->table_align_class = 'text-%s';
~~~

### Custom Footnote ID Format

~~~ .php
$parser->footnote_link_id = 'cite_note:%s';
~~~

### Custom Footnote Back ID Format

~~~ .php
$parser->footnote_back_link_id = 'cite_ref:%s-%s';
~~~

### Custom Footnote Class

~~~ .php
$parser->footnote_class = 'footnotes';
~~~

### Custom Footnote Link Class

~~~ .php
$parser->footnote_link_class = 'footnote-ref';
~~~

### Custom Footnote Back Link Class

~~~ .php
$parser->footnote_back_link_class = 'footnote-backref';
~~~

### Custom Footnote Link Text

~~~ .php
$parser->footnote_link_text = '[%s]';
~~~

~~~ .php
$parser->footnote_link_text = function($text) {
    return '[' . $text . ']';
};
~~~

### Custom Footnote Back Link Text

~~~ .php
$parser->footnote_back_link_text = '<i class="icon icon-back"></i>';
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