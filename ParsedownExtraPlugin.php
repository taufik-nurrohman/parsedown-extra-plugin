<?php

/**
 * Author: Taufik Nurrohman
 * URL: https://github.com/tovic/parsedown-extra-plugin
 * Version: 1.2.0
 */

class ParsedownExtraPlugin extends ParsedownExtra {

    const version = '1.2.0';


    // Begin config

    public $abbreviationData = array();

    public $blockCodeAttributes = array();

    public $blockCodeAttributesOnParent = false;

    public $blockCodeClassFormat = 'language-%s';

    public $blockCodeHtml = null;

    public $codeAttributes = array();

    public $codeHtml = null;

    public $footnoteAttributes = array();

    public $footnoteBackReferenceAttributes = array();

    public $footnoteBackReferenceHtml = '&#8617;';

    public $footnoteReferenceAttributes = array();

    public $footnoteReferenceHtml = null;

    public $imageAttributes = array();

    public $linkAttributes = array();

    public $referenceData = array();

    public $tableAttributes = array();

    public $tableColumnAttributes = array();

    public $voidElementSuffix = ' />';

    // End config


    protected $regexAttribute = '(?:[#.][-\w:\\\]+[ ]*|[-\w:\\\]+(?:=(?:["\'][^\n]*?["\']|[^\s]+)?)?[ ]*)';

    // Method aliases for every configuration property
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

    private function doAttributes(&$Element, $Key, $Arguments = array()) {
        $Attributes = isset($Element['attributes']) ? $Element['attributes'] : array();
        if (is_callable($this->{$Key})) {
            $Arguments = array_merge(array($Attributes, $Element), $Arguments);
            $Attributes = array_replace($Attributes, (array) call_user_func_array($this->{$Key}, $Arguments));
        } else {
            $Attributes = array_replace($Attributes, (array) $this->{$Key});
        }
        $Element['attributes'] = $Attributes;
    }

    private function doHtml(&$Element, $Key, $Escape = false, $Mode = 'text') {
        $Attributes = isset($Element['attributes']) ? $Element['attributes'] : array();
        $Html = isset($Element[$Mode]) ? $Element[$Mode] : "";
        if ($Escape) {
            $Html = self::escape($Html);
        }
        if (is_callable($this->{$Key})) {
            $Element[$Mode] = call_user_func($this->{$Key}, $Html, $Attributes, $Element);
        } else if (!empty($this->{$Key})) {
            $Element[$Mode] = sprintf($this->{$Key}, $Html);
        }
    }

    private function _setReferenceData() {
        if (!isset($this->DefinitionData['Reference'])) {
            $this->DefinitionData['Reference'] = $this->referenceData;
        } else if (!empty($this->referenceData)) {
            $this->DefinitionData['Reference'] = array_replace($this->referenceData, $this->DefinitionData['Reference']);
        }
        return $this;
    }

    protected function blockAbbreviation($Line) {
        // Allow empty abbreviations
        if (preg_match('/^\*\[(.+?)\]:[ ]*$/', $Line['text'], $matches)) {
            $this->DefinitionData['Abbreviation'][$matches[1]] = null;
            return array('hidden' => true);
        }
        $Data = (array) $this->abbreviationData;
        if (!isset($this->DefinitionData['Abbreviation'])) {
            $this->DefinitionData['Abbreviation'] = $Data;
        } else {
            $this->DefinitionData['Abbreviation'] = array_replace($Data, $this->DefinitionData['Abbreviation']);
        }
        return parent::blockAbbreviation($Line);
    }

    protected function blockCodeComplete($Block) {
        $this->doAttributes($Block['element']['element'], 'blockCodeAttributes');
        $this->doHtml($Block['element']['element'], 'blockCodeHtml', true);
        // Put code attributes on parent tag
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
        // Re-enable the multiple class name feature
        $Line['text'] = strtr(trim($Line['text']), array(
            ' ' => "\x1A",
            '.' => "\x1A."
        ));
        // Enable custom attribute syntax on code block
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
        $Alignments = $Block['alignments'];
        // `<thead>` or `<tbody>`
        foreach ($Block['element']['elements'] as $Index0 => &$Element0) {
            // `<tr>`
            foreach ($Element0['elements'] as $Index1 => &$Element1) {
                // `<th>` or `<td>`
                foreach ($Element1['elements'] as $Index2 => &$Element2) {
                    $this->doAttributes($Element2, 'tableColumnAttributes', array($Index2, $Alignments[$Index2]));
                }
            }
        }
        return $Block;
    }

    protected function blockTableComplete($Block) {
        $this->doAttributes($Block['element'], 'tableAttributes');
        return $Block;
    }

    protected function element(array $Element) {
        if (!$Any = parent::element($Element)) {
            return $Any;
        }
        if (substr($Any, -3) === ' />') {
            if (is_callable($this->voidElementSuffix)) {
                $Suffix = call_user_func($this->voidElementSuffix, isset($Element['attributes']) ? $Element['attributes'] : array(), $Element);
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
        $this->doAttributes($Inline['element'], 'codeAttributes');
        $this->doHtml($Inline['element'], 'codeHtml', true);
        $Inline['element']['rawHtml'] = $Inline['element']['text'];
        $Inline['element']['allowRawHtmlInSafeMode'] = true;
        unset($Inline['element']['text']);
        return $Inline;
    }

    protected function inlineImage($Excerpt) {
        $linkAttributes = $this->linkAttributes;
        $this->linkAttributes = $this->imageAttributes;
        $Inline = parent::inlineImage($Excerpt);
        $this->linkAttributes = $linkAttributes;
        unset($linkAttributes);
        return $Inline;
    }

    protected function inlineLink($Excerpt) {
        if (!$Inline = parent::inlineLink($Excerpt)) {
            return $Inline;
        }
        $this->doAttributes($Inline['element'], 'linkAttributes');
        $this->_setReferenceData();
        return $Inline;
    }

    protected function inlineUrl($Excerpt) {
        if (!$Inline = parent::inlineUrl($Excerpt)) {
            return $Inline;
        }
        $this->doAttributes($Inline['element'], 'linkAttributes');
        $this->_setReferenceData();
        return $Inline;
    }

    protected function inlineUrlTag($Excerpt) {
        if (!$Inline = parent::inlineUrlTag($Excerpt)) {
            return $Inline;
        }
        $this->doAttributes($Inline['element'], 'linkAttributes');
        $this->_setReferenceData();
        return $Inline;
    }

    protected function parseAttributeData($attributeString) {
        // Allow compact attributes
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

    static function isInternalLink($Link) {
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

    static function isExternalLink($Link) {
        return !self::isInternalLink($Link);
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