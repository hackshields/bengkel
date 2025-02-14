<?php

/**
 * @copyright Copyright (c) 2014 Carsten Brandt
 * @license https://github.com/cebe/markdown/blob/master/LICENSE
 * @link https://github.com/cebe/markdown#readme
 */
namespace cebe\markdown\block;

/**
 * Adds the list blocks
 */
trait ListTrait
{
    /**
     * @var bool enable support `start` attribute of ordered lists. This means that lists
     * will start with the number you actually type in markdown and not the HTML generated one.
     * Defaults to `false` which means that numeration of all ordered lists(<ol>) starts with 1.
     */
    public $keepListStartNumber = false;
    /**
     * identify a line as the beginning of an ordered list.
     */
    protected function identifyOl($line)
    {
        return (($l = $line[0]) > '0' && $l <= '9' || $l === ' ') && preg_match('/^ {0,3}\\d+\\.[ \\t]/', $line);
    }
    /**
     * identify a line as the beginning of an unordered list.
     */
    protected function identifyUl($line)
    {
        $l = $line[0];
        return ($l === '-' || $l === '+' || $l === '*') && (isset($line[1]) && (($l1 = $line[1]) === ' ' || $l1 === "\t")) || $l === ' ' && preg_match('/^ {0,3}[\\-\\+\\*][ \\t]/', $line);
    }
    /**
     * Consume lines for an ordered list
     */
    protected function consumeOl($lines, $current)
    {
        // consume until newline
        $block = ['list', 'list' => 'ol', 'attr' => [], 'items' => []];
        return $this->consumeList($lines, $current, $block, 'ol');
    }
    /**
     * Consume lines for an unordered list
     */
    protected function consumeUl($lines, $current)
    {
        // consume until newline
        $block = ['list', 'list' => 'ul', 'items' => []];
        return $this->consumeList($lines, $current, $block, 'ul');
    }
    private function consumeList($lines, $current, $block, $type)
    {
        $item = 0;
        $indent = '';
        $len = 0;
        $lastLineEmpty = false;
        // track the indentation of list markers, if indented more than previous element
        // a list marker is considered to be long to a lower level
        $leadSpace = 3;
        $marker = $type === 'ul' ? ltrim($lines[$current])[0] : '';
        for ($i = $current, $count = count($lines); $i < $count; $i++) {
            $line = $lines[$i];
            // match list marker on the beginning of the line
            $pattern = $type == 'ol' ? '/^( {0,' . $leadSpace . '})(\\d+)\\.[ \\t]+/' : '/^( {0,' . $leadSpace . '})\\' . $marker . '[ \\t]+/';
            if (preg_match($pattern, $line, $matches)) {
                if (($len = substr_count($matches[0], "\t")) > 0) {
                    $indent = str_repeat("\t", $len);
                    $line = substr($line, strlen($matches[0]));
                } else {
                    $len = strlen($matches[0]);
                    $indent = str_repeat(' ', $len);
                    $line = substr($line, $len);
                }
                if ($i === $current) {
                    $leadSpace = strlen($matches[1]) + 1;
                }
                if ($type == 'ol' && $this->keepListStartNumber) {
                    // attr `start` for ol
                    if (!isset($block['attr']['start']) && isset($matches[2])) {
                        $block['attr']['start'] = $matches[2];
                    }
                }
                $block['items'][++$item][] = $line;
                $block['lazyItems'][$item] = $lastLineEmpty;
                $lastLineEmpty = false;
            } elseif (ltrim($line) === '') {
                // line is empty, may be a lazy list
                $lastLineEmpty = true;
                // two empty lines will end the list
                if (!isset($lines[$i + 1][0])) {
                    break;
                    // next item is the continuation of this list -> lazy list
                } elseif (preg_match($pattern, $lines[$i + 1])) {
                    $block['items'][$item][] = $line;
                    $block['lazyItems'][$item] = true;
                    // next item is indented as much as this list -> lazy list if it is not a reference
                } elseif (strncmp($lines[$i + 1], $indent, $len) === 0 || !empty($lines[$i + 1]) && $lines[$i + 1][0] == "\t") {
                    $block['items'][$item][] = $line;
                    $nextLine = $lines[$i + 1][0] === "\t" ? substr($lines[$i + 1], 1) : substr($lines[$i + 1], $len);
                    $block['lazyItems'][$item] = !method_exists($this, 'identifyReference') || !$this->identifyReference($nextLine);
                    // everything else ends the list
                } else {
                    break;
                }
            } else {
                if ($line[0] === "\t") {
                    $line = substr($line, 1);
                } elseif (strncmp($line, $indent, $len) === 0) {
                    $line = substr($line, $len);
                }
                $block['items'][$item][] = $line;
                $lastLineEmpty = false;
            }
        }
        foreach ($block['items'] as $itemId => $itemLines) {
            $content = [];
            if (!$block['lazyItems'][$itemId]) {
                $firstPar = [];
                while (!empty($itemLines) && rtrim($itemLines[0]) !== '' && $this->detectLineType($itemLines, 0) === 'paragraph') {
                    $firstPar[] = array_shift($itemLines);
                }
                $content = $this->parseInline(implode("\n", $firstPar));
            }
            if (!empty($itemLines)) {
                $content = array_merge($content, $this->parseBlocks($itemLines));
            }
            $block['items'][$itemId] = $content;
        }
        return [$block, $i];
    }
    /**
     * Renders a list
     */
    protected function renderList($block)
    {
        $type = $block['list'];
        if (!empty($block['attr'])) {
            $output = "<{$type} " . $this->generateHtmlAttributes($block['attr']) . ">\n";
        } else {
            $output = "<{$type}>\n";
        }
        foreach ($block['items'] as $item => $itemLines) {
            $output .= '<li>' . $this->renderAbsy($itemLines) . "</li>\n";
        }
        return $output . "</{$type}>\n";
    }
    /**
     * Return html attributes string from [attrName => attrValue] list
     * @param array $attributes the attribute name-value pairs.
     * @return string
     */
    private function generateHtmlAttributes($attributes)
    {
        foreach ($attributes as $name => $value) {
            $attributes[$name] = "{$name}=\"{$value}\"";
        }
        return implode(' ', $attributes);
    }
    protected abstract function parseBlocks($lines);
    protected abstract function parseInline($text);
    protected abstract function renderAbsy($absy);
    protected abstract function detectLineType($lines, $current);
}

?>