<?php

/*! <https://github.com/taufik-nurrohman/generic-syntax-highlighter> */

function SH($s) {
    $s = str_replace(['&quot;', '&apos;', '&#34;', '&#39;'], ['"', "'", '"', "'"], $s);
    return '<span style="color:#000000">' . preg_replace_callback('/' . implode('|', [
        '<.*?>', // embedded HTML tags
        '&lt;!\-\-[\s\S]*?\-\-&gt;', // HTML comments
        '\/\/[^\n]+', // comments
        '#\s+[^\n]+', // comments
        '\/\*[\s\S]*?\*\/', // comments
        '"(?:[^\n"\\\]|\\\.)*"', // strings
        '\'(?:[^\n\'\\\]|\\\.)*\'', // strings
        '`(?:[^`\\\]|\\\.)*`', // ES6 strings
        '&lt;\/?[\w:!-]+.*?&gt;', // HTML tags
        '&lt;\?\S*', '\?&gt;', // templates
        '\/[^\n]+\/[gimuy]*', // regular expressions
        '\$\w+', // PHP variables
        '&amp;[^\s;]+;', // entities
        '\b(?:true|false|null)\b', // null and booleans
        '(?:\d*\\.)?\d+', // numbers
        '\b(?:a(?:bstract|lias|nd|rguments|rray|s(?:m|sert)?|uto)|b(?:ase|egin|ool(?:ean)?|reak|yte)|c(?:ase|atch|har|hecked|lass|lone|ompl|onst|ontinue)|de(?:bugger|cimal|clare|f(?:ault|er)?|init|l(?:egate|ete)?)|do|double|e(?:cho|ls?if|lse(?:if)?|nd|nsure|num|vent|x(?:cept|ec|p(?:licit|ort)|te(?:nds|nsion|rn)))|f(?:allthrough|alse|inal(?:ly)?|ixed|loat|or(?:each)?|riend|rom|unc(?:tion)?)|global|goto|guard|i(?:f|mp(?:lements|licit|ort)|n(?:it|clude(?:_once)?|line|out|stanceof|t(?:erface|ernal)?)?|s)|l(?:ambda|et|ock|ong)|m(?:odule|utable)|NaN|n(?:amespace|ative|ext|ew|il|ot|ull)|o(?:bject|perator|r|ut|verride)|p(?:ackage|arams|rivate|rotected|rotocol|ublic)|r(?:aise|e(?:adonly|do|f|gister|peat|quire(?:_once)?|scue|strict|try|turn))|s(?:byte|ealed|elf|hort|igned|izeof|tatic|tring|truct|ubscript|uper|ynchronized|witch)|t(?:emplate|hen|his|hrows?|ransient|rue|ry|ype(?:alias|def|id|name|of))|u(?:n(?:checked|def(?:ined)?|ion|less|signed|til)|se|sing)|v(?:ar|irtual|oid|olatile)|w(?:char_t|hen|here|hile|ith)|xor|yield)\b' // keywords
    ]) . '/', function($a) {
        $a = $a[0];
        if (!empty($a)) {
            if (($a[0] === '<' && substr($a, -1) === '>') || preg_match('/^\W$/', $a)) {
                // skip punctuations and "real" tags ...
            } else if (substr($a, 0, 5) === '&lt;?' || $a === '?&gt;' || substr($a, 0, 7) === '&lt;!--') {
                $a = '<span style="color:#008000;font-style:italic;">' . $a . '</span>'; // HTML comments and templates
            } else if (substr($a, 0, 5) === '&lt;!') {
                $a = '<span style="color:#4682B4;font-style:italic;">' . $a . '</span>'; // document types
            } else if (substr($a, 0, 4) === '&lt;' && substr($a, -4) === '&gt;') {
                $a = '<span style="color:inherit;">' . SH_TAG($a) . '</span>'; // tags
            } else if (strpos('/#', $a[0]) !== false && preg_match('/^(\/\/|#\s+|\/\*)/', $a)) {
                $a = '<span style="color:#808080;font-style:italic;">' . $a . '</span>'; // comments
            } else if (strpos('"\'`', $a[0]) !== false) {
                $a = '<span style="color:#008000;">' . $a . '</span>'; // strings
            } else if ($a[0] === '/') {
                $a = '<span style="color:#4682B4;">' . $a . '</span>'; // regular expressions
            } else if (is_numeric($a)) {
                $a = '<span style="color:#0000FF;">' . $a . '</span>'; // numbers
            } else if ($a === 'true' || $a === 'false' || $a === 'null') {
                $a = '<span style="color:#A52A2A;font-weight:bold;">' . $a . '</span>'; // null and booleans
            } else if ($a[0] === '$') {
                $a = '<span style="font-weight:bold;">' . $a . '</span>'; // PHP variables
            } else if (substr($a, 0, 5) === '&amp;' && substr($a, -1) === ';') {
                $a = '<span style="color:#FF4500;">' . $a . '</span>'; // entities
            } else {
                $a = '<span style="color:#FF0000;">' . $a . '</span>'; // keywords
            }
        }
        return $a;
    }, $s) . '</span>';
}

function SH_TAG($s) {
    return preg_replace_callback('/&lt;(\/?)(\S+)(\s.*?)?&gt;/', function($m) {
        $m[2] = '<span style="color:#800080;font-weight:bold;">' . $m[2] . '</span>';
        if (!empty($m[3])) {
            $m[3] = preg_replace_callback('/(\s+)([^\s=]+)(?:=("(?:[^\n"\\\]|\\\.)*"|\'(?:[^\n\'\\\]|\\\.)*\'|[^\s"\']+))?/', function($m) {
                $o = $m[1] . '<span style="font-weight:bold;">' . $m[2] . '</span>';
                if (!empty($m[3])) {
                    $o .= '=<span style="color:#0000FF;">' . $m[3] . '</span>';
                }
                return $o;
            }, $m[3]);
        } else {
            $m[3] = "";
        }
        return '&lt;' . $m[1] . $m[2] . $m[3] . '&gt;';
    }, $s);
}

function GSH($content) {
    // do something with `DOMDocument` class ...
}
