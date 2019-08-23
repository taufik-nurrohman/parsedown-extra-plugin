<?php

#
#
# Parsedown Extra Plugin
# https://github.com/tovic/parsedown-extra-plugin
#
# (c) Emanuil Rusev
# http://erusev.com
#
# (c) Taufik Nurrohman
# https://mecha-cms.com
#
# For the full license information, view the LICENSE file that was distributed
# with this source code.
#
#

class ParsedownExtraPlugin extends ParsedownExtra {

    const version = '1.2.0-beta-1';


    # config

    public $abbreviationData = array();

    public $blockCodeAttributes = array();

    public $blockCodeAttributesOnParent = false;

    public $blockCodeClassFormat = 'language-%s';

    public $blockCodeHtml = null;

    public $codeAttributes = array();

    public $codeHtml = null;

    public $footnoteAttributes = array();

    public $footnoteBackLinkAttributes = array();

    public $footnoteBackLinkHtml = '&#8617;';

    public $footnoteBackReferenceAttributes = array();

    public $footnoteLinkAttributes = array();

    public $footnoteLinkHtml = null;

    public $footnoteReferenceAttributes = array();

    public $imageAttributes = array();

    public $linkAttributes = array();

    public $referenceData = array();

    public $tableAttributes = array();

    public $tableColumnAttributes = array();

    public $voidElementSuffix = ' />';

    # config


    protected $regexAttribute = '(?:[#.][-\w:\\\]+[ ]*|[-\w:\\\]+(?:=(?:["\'][^\n]*?["\']|[^\s]+)?)?[ ]*)';

    # Method aliases for every configuration property
    public function __call($key, array $arguments = array()) {
        $property = lcfirst(substr($key, 3));
        if (strpos($key, 'set') === 0 && property_exists($this, $property)) {
            $this->{$property} = $arguments[0];
            return $this;
        }
        throw new Exception('Method ' . $key . ' does not exists.');
    }

    public function __construct() {
        if (version_compare(parent::version, '0.8.0-beta-1') < 0) {
            throw new Exception('ParsedownExtraPlugin requires a later version of Parsedown');
        }
        parent::__construct();
    }

    protected function blockAbbreviation($Line) {
        # Allow empty abbreviations
        if (preg_match('/^\*\[(.+?)\]:[ ]*$/', $Line['text'], $matches)) {
            $this->DefinitionData['Abbreviation'][$matches[1]] = null;
            return array('hidden' => true);
        }
        self::doSetData($this->DefinitionData['Abbreviation'], $this->abbreviationData);
        return parent::blockAbbreviation($Line);
    }

    protected function blockCodeComplete($Block) {
        self::doSetAttributes($Block['element']['element'], $this->blockCodeAttributes);
        self::doSetHtml($Block['element']['element'], $this->blockCodeHtml, true);
        # Put code attributes on parent tag
        if ($this->blockCodeAttributesOnParent) {
            $Block['element']['attributes'] = $Block['element']['element']['attributes'];
            unset($Block['element']['element']['attributes']);
        }
        $Block['element']['element']['rawHtml'] = $Block['element']['element']['text'];
        $Block['element']['element']['allowRawHtmlInSafeMode'] = true;
        unset($Block['element']['element']['text']);
        return $Block;
    }

    protected function blockFencedCode($Line) {
        # Re-enable the multiple class name feature
        $Line['text'] = strtr(trim($Line['text']), array(
            ' ' => "\x1A",
            '.' => "\x1A."
        ));
        # Enable custom attribute syntax on code block
        $Attributes = array();
        if (strpos($Line['text'], '{') !== false && substr($Line['text'], -1) === '}') {
            $Parts = explode('{', $Line['text'], 2);
            $Attributes = $this->parseAttributeData(strtr(substr($Parts[1], 0, -1), "\x1A", ' '));
            $Line['text'] = trim($Parts[0]);
        }
        if (!$Block = parent::blockFencedCode($Line)) {
            return $Block;
        }
        if ($Attributes) {
            $Block['element']['element']['attributes'] = $Attributes;
        } else if (isset($Block['element']['element']['attributes']['class'])) {
            $Classes = explode("\x1A", strtr($Block['element']['element']['attributes']['class'], ' ', "\x1A"));
            // `~~~ php` → `<pre><code class="language-php">`
            // `~~~ php html` → `<pre><code class="language-php language-html">`
            // `~~~ .php` → `<pre><code class="php">`
            // `~~~ .php.html` → `<pre><code class="php html">`
            // `~~~ .php html` → `<pre><code class="php language-html">`
            // `~~~ {.php #foo}` → `<pre><code id="foo" class="php">`
            $Results = [];
            foreach ($Classes as $Class) {
                if ($Class === "" || $Class === str_replace('%s', "", $this->blockCodeClassFormat)) {
                    continue;
                }
                if ($Class[0] === '.') {
                    $Results[] = substr($Class, 1);
                } else {
                    $Results[] = sprintf($this->blockCodeClassFormat, $Class);
                }
            }
            $Block['element']['element']['attributes']['class'] = implode(' ', array_unique($Results));
        }
        return $Block;
    }

    protected function blockFencedCodeComplete($Block) {
        return $this->blockCodeComplete($Block);
    }

    protected function blockTableContinue($Line, array $Block) {
        if (!$Block = parent::blockTableContinue($Line, $Block)) {
            return $Block;
        }
        $Aligns = $Block['alignments'];
        // `<thead>` or `<tbody>`
        foreach ($Block['element']['elements'] as $Index0 => &$Element0) {
            // `<tr>`
            foreach ($Element0['elements'] as $Index1 => &$Element1) {
                // `<th>` or `<td>`
                foreach ($Element1['elements'] as $Index2 => &$Element2) {
                    self::doSetAttributes($Element2, $this->tableColumnAttributes, array($Aligns[$Index2], $Index2));
                }
            }
        }
        return $Block;
    }

    protected function blockTableComplete($Block) {
        self::doSetAttributes($Block['element'], $this->tableAttributes);
        return $Block;
    }

    protected function buildFootnoteElement() {
        $DefinitionData = $this->DefinitionData['Footnote'];
        if (!$Footnotes = parent::buildFootnoteElement()) {
            return $Footnotes;
        }
        $DefinitionKey = array_keys($DefinitionData);
        $DefinitionData = array_values($DefinitionData);
        self::doSetAttributes($Footnotes, $this->footnoteAttributes);
        foreach ($Footnotes['elements'][1]['elements'] as $Index0 => &$Element0) {
            $Name = $DefinitionKey[$Index0];
            $Count = $DefinitionData[$Index0]['count'];
            $Args = array(is_numeric($Name) ? (float) $Name : $Name, $Count);
            self::doSetAttributes($Element0, $this->footnoteBackReferenceAttributes, $Args);
            foreach ($Element0['elements'] as $Index1 => &$Element1) {
                $Count = 0;
                foreach ($Element1['elements'] as $Index2 => &$Element2) {
                    if (!isset($Element2['name']) || $Element2['name'] !== 'a') {
                        continue;
                    }
                    $Args[1] = ++$Count;
                    self::doSetAttributes($Element2, $this->footnoteBackLinkAttributes, $Args);
                    self::doSetHtml($Element2, $this->footnoteBackLinkHtml, false, 'rawHtml');
                }
            }
        }
        return $Footnotes;
    }

    protected function element(array $Element) {
        if (!$Any = parent::element($Element)) {
            return $Any;
        }
        if (substr($Any, -3) === ' />') {
            if (is_callable($this->voidElementSuffix)) {
                $Attributes = self::doGetAttributes($Element);
                $Html = self::doGetHtml($Element);
                $Suffix = call_user_func($this->voidElementSuffix, $Html, $Attributes, $Element);
            } else {
                $Suffix = $this->voidElementSuffix;
            }
            $Any = substr_replace($Any, $Suffix, -3);
        }
        return $Any;
    }

    protected function inlineCode($Excerpt) {
        if (!$Inline = parent::inlineCode($Excerpt)) {
            return $Inline;
        }
        self::doSetAttributes($Inline['element'], $this->codeAttributes);
        self::doSetHtml($Inline['element'], $this->codeHtml, true);
        $Inline['element']['rawHtml'] = $Inline['element']['text'];
        $Inline['element']['allowRawHtmlInSafeMode'] = true;
        unset($Inline['element']['text']);
        return $Inline;
    }

    protected function inlineFootnoteMarker($Excerpt) {
        if (!$Inline = parent::inlineFootnoteMarker($Excerpt)) {
            return $Inline;
        }
        $Name = null;
        if (preg_match('/^\[\^(.+?)\]/', $Excerpt['text'], $matches)) {
            $Name = $matches[1];
        }
        $Args = array(is_numeric($Name) ? (float) $Name : $Name, $this->DefinitionData['Footnote'][$Name]['count']);
        self::doSetAttributes($Inline['element'], $this->footnoteReferenceAttributes, $Args);
        self::doSetAttributes($Inline['element']['element'], $this->footnoteLinkAttributes, $Args);
        self::doSetHtml($Inline['element']['element'], $this->footnoteLinkHtml, false, 'text', $Args);
        $Inline['element']['element']['rawHtml'] = $Inline['element']['element']['text'];
        $Inline['element']['element']['allowRawHtmlInSafeMode'] = true;
        unset($Inline['element']['element']['text']);
        return $Inline;
    }

    protected function inlineImage($Excerpt) {
        $linkAttributes = $this->linkAttributes;
        $this->linkAttributes = $this->imageAttributes;
        $Inline = parent::inlineImage($Excerpt);
        $Internal = isset($Inline['element']['attributes']['src']) ? self::isInternalLink($Inline['element']['attributes']['src']) : null;
        self::doSetAttributes($Inline['element'], $this->linkAttributes, array($Internal));
        $this->linkAttributes = $linkAttributes;
        unset($linkAttributes);
        return $Inline;
    }

    protected function inlineLink($Excerpt) {
        if (!$Inline = parent::inlineLink($Excerpt)) {
            return $Inline;
        }
        $Internal = isset($Inline['element']['attributes']['href']) ? self::isInternalLink($Inline['element']['attributes']['href']) : null;
        self::doSetAttributes($Inline['element'], $this->linkAttributes, array($Internal));
        self::doSetData($this->DefinitionData['Reference'], $this->referenceData);
        return $Inline;
    }

    protected function inlineUrl($Excerpt) {
        if (!$Inline = parent::inlineUrl($Excerpt)) {
            return $Inline;
        }
        $Internal = isset($Inline['element']['attributes']['href']) ? self::isInternalLink($Inline['element']['attributes']['href']) : null;
        self::doSetAttributes($Inline['element'], $this->linkAttributes, array($Internal));
        self::doSetData($this->DefinitionData['Reference'], $this->referenceData);
        return $Inline;
    }

    protected function inlineUrlTag($Excerpt) {
        if (!$Inline = parent::inlineUrlTag($Excerpt)) {
            return $Inline;
        }
        $Internal = isset($Inline['element']['attributes']['href']) ? self::isInternalLink($Inline['element']['attributes']['href']) : null;
        self::doSetAttributes($Inline['element'], $this->linkAttributes, array($Internal));
        self::doSetData($this->DefinitionData['Reference'], $this->referenceData);
        return $Inline;
    }

    protected function parseAttributeData($attributeString) {
        # Allow compact attributes
        $attributeString = strtr($attributeString, array(
            '#' => ' #',
            '.' => ' .'
        ));
        if (strpos($attributeString, '="') !== false || strpos($attributeString, "='") !== false) {
            $attributeString = preg_replace_callback('#([-\w]+=)(["\'])([^\n]*?)\2#', function($matches) {
                $value = strtr($matches[3], array(
                    ' #' => '#',
                    ' .' => '.',
                    ' ' => "\x1A"
                ));
                return $matches[1] . $matches[2] . $value . $matches[2];
            }, $attributeString);
        }
        $Attributes = array();
        foreach (explode(' ', $attributeString) as $v) {
            if (!$v) {
                continue;
            }
            // `{#foo}`
            if ($v[0] === '#' && isset($v[1])) {
                $Attributes['id'] = substr($v, 1);
            // `{.foo}`
            } else if ($v[0] === '.' && isset($v[1])) {
                $Attributes['class'][] = substr($v, 1);
            // ~
            } else if (strpos($v, '=') !== false) {
                $vv = explode('=', $v, 2);
                // `{foo=}`
                if ($vv[1] === "") {
                    $Attributes[$vv[0]] = "";
                // `{foo="bar baz"}`
                // `{foo='bar baz'}`
                } else if ($vv[1][0] === '"' && substr($vv[1], -1) === '"' || $vv[1][0] === "'" && substr($vv[1], -1) === "'") {
                    $Attributes[$vv[0]] = stripslashes(strtr(substr(substr($vv[1], 1), 0, -1), "\x1A", ' '));
                // `{foo=bar}`
                } else {
                    $Attributes[$vv[0]] = $vv[1];
                }
            // `{foo}`
            } else {
                $Attributes[$v] = $v;
            }
        }
        if (isset($Attributes['class'])) {
            $Attributes['class'] = implode(' ', array_unique($Attributes['class']));
        }
        return $Attributes;
    }

    protected static function doSetAttributes(&$Element, $From, $Args = array()) {
        $Attributes = self::doGetAttributes($Element);
        $Html = self::doGetHtml($Element);
        if (is_callable($From)) {
            $Args = array_merge(array($Html, $Attributes, $Element), $Args);
            $Element['attributes'] = array_replace($Attributes, (array) call_user_func_array($From, $Args));
        } else {
            $Element['attributes'] = array_replace($Attributes, (array) $From);
        }
    }

    protected static function doSetData(&$To, $From) {
        $To = array_replace((array) $To, (array) $From);
    }

    protected static function doSetHtml(&$Element, $From, $Esc = false, $Mode = 'text', $Args = array()) {
        $Attributes = self::doGetAttributes($Element);
        $Html = self::doGetHtml($Element);
        if ($Esc) {
            $Html = self::escape($Html);
        }
        if (is_callable($From)) {
            $Args = array_merge(array($Html, $Attributes, $Element), $Args);
            $Element[$Mode] = call_user_func_array($From, $Args);
        } else if (!empty($From)) {
            $Element[$Mode] = sprintf($From, $Html);
        }
    }

    protected static function doGetAttributes($Element) {
        if (isset($Element['attributes'])) {
            return (array) $Element['attributes'];
        }
        return array();
    }

    protected static function doGetHtml($Element) {
        if (isset($Element['text'])) {
            return $Element['text'];
        }
        if (isset($Element['rawHtml'])) {
            return $Element['rawHtml'];
        }
        return null;
    }

    protected static function isInternalLink($Link) {
        if (isset($_SERVER['HTTP_HOST'])) {
            $Host = $_SERVER['HTTP_HOST'];
        } else if (isset($_SERVER['SERVER_NAME'])) {
            $Host = $_SERVER['SERVER_NAME'];
        } else {
            $Host = "";
        }
        $Internal = !$Link || // `<a href="">`
                    strpos($Link, 'https://' . $Host) === 0 || // `<a href="https://127.0.0.1">`
                    strpos($Link, 'http://' . $Host) === 0 || // `<a href="http://127.0.0.1">`
                    strpos($Link, '/') === 0 || // `<a href="/foo/bar">`
                    strpos($Link, '?') === 0 || // `<a href="?foo=bar">`
                    strpos($Link, '#') === 0 || // `<a href="#foo">`
                    strpos($Link, 'data:') === 0 || // `<a href="data:text/html,asdf">`
                    strpos($Link, 'javascript:') === 0 || // `<a href="javascript:;">`
                    strpos($Link, '.') === 0 || // `<a href="../foo/bar">`
                    strpos($Link, '://') === false; // `<a href="foo/bar">`
        if (strpos($Link, '//') === 0 && strpos($Link, '//' . $Host) !== 0) {
            return false; // `<a href="//example.com">`
        }
        return $Internal;
    }

}




/*
class ParsedownExtraPlugin extends ParsedownExtra {


    // ~
    protected function inlineFootnoteMarker($excerpt) {
        if (preg_match('#^\[\^(.+?)\]#', $excerpt['text'], $m)) {
            $name = $m[1];
            if (!isset($this->DefinitionData['Footnote'][$name])) return;
            ++$this->DefinitionData['Footnote'][$name]['count'];
            if (!isset($this->DefinitionData['Footnote'][$name]['number'])) {
                $this->DefinitionData['Footnote'][$name]['number'] = ++$this->footnoteCount;
            }
            $text = $this->DefinitionData['Footnote'][$name]['number'];
            if (is_callable($this->footnote_link_text)) {
                $text = call_user_func($this->footnote_link_text, $text, $excerpt, $m, $this);
            } else if ($this->footnote_link_text) {
                $text = sprintf($this->footnote_link_text, $text);
            }
            $element = array(
                'name' => 'sup',
                'attributes' => array('id' => sprintf($this->footnote_back_link_id, $this->DefinitionData['Footnote'][$name]['count'], $name)),
                'handler' => 'element',
                'text' => array(
                    'name' => 'a',
                    'attributes' => array(
                        'href' => '#' . sprintf($this->footnote_link_id, $name),
                        'class' => $this->footnote_link_class
                    ),
                    'text' => $text
                )
            );
            return array(
                'extent' => strlen($m[0]),
                'element' => $element
            );
        }
    }

    // ~
    private $footnoteCount = 0;

    // ~
    protected function buildFootnoteElement() {
        $element = array(
            'name' => 'div',
            'attributes' => array('class' => $this->footnote_class),
            'handler' => 'elements',
            'text' => array(
                array('name' => 'hr'),
                array(
                    'name' => 'ol',
                    'handler' => 'elements',
                    'text' => array()
                )
            )
        );
        uasort($this->DefinitionData['Footnote'], 'parent::sortFootnotes');
        foreach ($this->DefinitionData['Footnote'] as $id => $data) {
            if (!isset($data['number'])) continue;
            $text = $data['text'];
            $text = parent::text($text);
            $numbers = range(1, $data['count']);
            $Data = "";
            foreach ($numbers as $number) {
                $Data .= ' <a href="#' . sprintf($this->footnote_back_link_id, $number, $id) . '" rev="footnote" class="' . $this->footnote_back_link_class . '">' . $this->footnote_back_link_text . '</a>';
            }
            $Data = substr($Data, 1);
            if (substr($text, -4) === '</p>') {
                $Data = '&#160;' . $Data;
                $text = substr_replace($text, $Data . '</p>', -4);
            } else {
                $text .= "\n" . '<p>' . $Data . '</p>';
            }
            $element['text'][1]['text'][] = array(
                'name' => 'li',
                'attributes' => array('id' => sprintf($this->footnote_link_id, $id)),
                'text' => "\n" . $text . "\n"
            );
        }
        return $element;
    }

}
*/