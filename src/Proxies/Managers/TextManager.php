<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\ProxyManager;

/**
 * Text Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class TextManager extends ProxyManager
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Init manager
     *
     * @return void
     */
    protected function init(): void {}

    /*----------------------------------------*
     * Convert
     *----------------------------------------*/

    /**
     * Convert to pascal case
     *
     * @param string $text
     * @return string
     */
    public function toPascal(string $text): string
    {
        return str_replace(" ", "", ucwords(str_replace(["-", "_"], " ", $text)));
    }

    /**
     * Convert to camel case
     *
     * @param string $text
     * @return string
     */
    public function toCamel(string $text): string
    {
        return lcfirst($this->toPascal($text));
    }

    /**
     * Convert to snake case
     *
     * @param string $text
     * @return string
     */
    public function toSnake(string $text): string
    {
        return strtolower(preg_replace("/(?<!^)[A-Z]/", "_$0", $text));
    }

    /**
     * Convert to kebab case
     *
     * @param string $text
     * @return string
     */
    public function toKebab(string $text): string
    {
        return str_replace("_", "-", $this->toSnake($text));
    }

    /**
     * Convert to upper case
     *
     * @param string $text
     * @return string
     */
    public function toUpper(string $text): string
    {
        return strtoupper($text);
    }

    /**
     * Convert to lower case
     *
     * @param string $text
     * @return string
     */
    public function toLower(string $text): string
    {
        return strtolower($text);
    }

    /**
     * Convert to upper snake case
     *
     * @param string $text
     * @return string
     */
    public function toUpperSnake(string $text): string
    {
        return $this->toSnake($this->toUpper($text));
    }

    /*----------------------------------------*
     * Check
     *----------------------------------------*/

    /**
     * Hiragana pattern
     *
     * @var string
     */
    protected string $hiragana = "ぁ-んー";

    /**
     * Katakana pattern
     *
     * @var string
     */
    protected string $katakana = "ァ-ヶー";

    /**
     * Kanji pattern
     *
     * @var string
     */
    protected string $kanji = "一-龠";

    /**
     * Alphabet pattern
     *
     * @var string
     */
    protected string $alphabet = "a-zA-Z";

    /**
     * Alphabet lower case pattern
     *
     * @var string
     */
    protected string $alphabetLower = "a-z";

    /**
     * Alphabet upper case pattern
     *
     * @var string
     */
    protected string $alphabetUpper = "A-Z";

    /**
     * Alphabet full width pattern
     *
     * @var string
     */
    protected string $alphabetFullWidth = "ａ-ｚＡ-Ｚ";

    /**
     * Alphabet full width lower case pattern
     *
     * @var string
     */
    protected string $alphabetFullWidthLower = "ａ-ｚ";

    /**
     * Alphabet full width upper case pattern
     *
     * @var string
     */
    protected string $alphabetFullWidthUpper = "Ａ-Ｚ";

    /**
     * Number pattern
     *
     * @var string
     */
    protected string $number = "0-9";

    /**
     * Number full width pattern
     *
     * @var string
     */
    protected string $numberFullWidth = "０-９";

    /*----------------------------------------*
     * Method
     *----------------------------------------*/

    /**
     * Whether string configured only
     *
     * @param string $pattern
     * @param string $text
     * @return bool
     */
    public function is(string $pattern, string $text): bool
    {
        return preg_match("/^[{$pattern}]+$/u", $text);
    }

    /**
     * Whether string contains
     *
     * @param string $pattern
     * @param string $text
     * @return bool
     */
    public function has(string $pattern, string $text): bool
    {
        return preg_match("/[{$pattern}]+/u", $text);
    }

    /**
     * Whether string configured only hiragana
     *
     * @param string $text
     * @return bool
     */
    public function isHiragana(string $text): bool
    {
        return $this->is($this->hiragana, $text);
    }

    /**
     * Whether string contains hiragana
     *
     * @param string $text
     * @return bool
     */
    public function hasHiragana(string $text): bool
    {
        return $this->has($this->hiragana, $text);
    }

    /**
     * Whether string configured only katakana
     *
     * @param string $text
     * @return bool
     */
    public function isKatakana(string $text): bool
    {
        return $this->is($this->katakana, $text);
    }

    /**
     * Whether string contains katakana
     *
     * @param string $text
     * @return bool
     */
    public function hasKatakana(string $text): bool
    {
        return $this->has($this->katakana, $text);
    }

    /**
     * Whether string configured only kanji
     *
     * @param string $text
     * @return bool
     */
    public function isKanji(string $text): bool
    {
        return $this->is($this->kanji, $text);
    }

    /**
     * Whether string contains kanji
     *
     * @param string $text
     * @return bool
     */
    public function hasKanji(string $text): bool
    {
        return $this->has($this->kanji, $text);
    }

    /**
     * Whether string configured only alphabet
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabet(string $text): bool
    {
        return $this->is($this->alphabet, $text);
    }

    /**
     * Whether string contains alphabet
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabet(string $text): bool
    {
        return $this->has($this->alphabet, $text);
    }

    /**
     * Whether string configured only alphabet lower case
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetLower(string $text): bool
    {
        return $this->is($this->alphabetLower, $text);
    }

    /**
     * Whether string contains alphabet lower case
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetLower(string $text): bool
    {
        return $this->has($this->alphabetLower, $text);
    }

    /**
     * Whether string configured only alphabet upper case
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetUpper(string $text): bool
    {
        return $this->is($this->alphabetUpper, $text);
    }

    /**
     * Whether string contains alphabet upper case
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetUpper(string $text): bool
    {
        return $this->has($this->alphabetUpper, $text);
    }

    /**
     * Whether string configured only alphabet full width
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetFullWidth(string $text): bool
    {
        return $this->is($this->alphabetFullWidth, $text);
    }

    /**
     * Whether string contains alphabet full width
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetFullWidth(string $text): bool
    {
        return $this->has($this->alphabetFullWidth, $text);
    }

    /**
     * Whether string configured only alphabet full width lower case
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetFullWidthLower(string $text): bool
    {
        return $this->is($this->alphabetFullWidthLower, $text);
    }

    /**
     * Whether string contains alphabet full width lower case
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetFullWidthLower(string $text): bool
    {
        return $this->has($this->alphabetFullWidthLower, $text);
    }

    /**
     * Whether string configured only alphabet full width upper case
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetFullWidthUpper(string $text): bool
    {
        return $this->is($this->alphabetFullWidthUpper, $text);
    }

    /**
     * Whether string contains alphabet full width upper case
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetFullWidthUpper(string $text): bool
    {
        return $this->has($this->alphabetFullWidthUpper, $text);
    }

    /**
     * Whether string configured only number
     *
     * @param string $text
     * @return bool
     */
    public function isNumber(string $text): bool
    {
        return $this->is($this->number, $text);
    }

    /**
     * Whether string contains number
     *
     * @param string $text
     * @return bool
     */
    public function hasNumber(string $text): bool
    {
        return $this->has($this->number, $text);
    }

    /**
     * Whether string configured only number full width
     *
     * @param string $text
     * @return bool
     */
    public function isNumberFullWidth(string $text): bool
    {
        return $this->is($this->numberFullWidth, $text);
    }

    /**
     * Whether string contains number full width
     *
     * @param string $text
     * @return bool
     */
    public function hasNumberFullWidth(string $text): bool
    {
        return $this->has($this->numberFullWidth, $text);
    }

    /*----------------------------------------*
     * Remove
     *----------------------------------------*/

    /**
     * Remove
     *
     * @param string|array $search
     * @param string $text
     * @return string
     */
    public function remove($search, string $text): string
    {
        return str_replace($search, "", $text);
    }

    /**
     * Remove space
     *
     * @param string $text
     * @return string
     */
    public function removeSpace(string $text): string
    {
        return $this->remove([" ", "　"], $text);
    }

    /**
     * Remove half width space
     *
     * @param string $text
     * @return string
     */
    public function removeHalfWidthSpace(string $text): string
    {
        return $this->remove(" ", $text);
    }

    /**
     * Remove full width space
     *
     * @param string $text
     * @return string
     */
    public function removeFullWidthSpace(string $text): string
    {
        return $this->remove("　", $text);
    }

    /**
     * Remove newline
     *
     * @param string $text
     * @return string
     */
    public function removeNewline(string $text): string
    {
        return $this->remove(array_merge(
            ["\r\n", "\n\r", "\r", "\n"],
            [PHP_EOL]
        ), $text);
    }

    /**
     * Remove tab
     *
     * @param string $text
     * @return string
     */
    public function removeTab(string $text): string
    {
        return $this->remove("\t", $text);
    }

    /**
     * Remove return
     *
     * @param string $text
     * @return string
     */
    public function removeReturn(string $text): string
    {
        return $this->remove("\r", $text);
    }

    /**
     * Remove by length
     *
     * @param string $text
     * @param int $start
     * @param int $length
     * @return string
     */
    public function removeLength(string $text, int $start, int $length): string
    {
        return mb_substr($text, $start, $length);
    }

    /**
     * Remove from start
     *
     * @param string $text
     * @param int $length
     * @return string
     */
    public function removeFromStart(string $text, int $length): string
    {
        return $this->removeLength($text, 0, $length);
    }

    /**
     * Remove from end
     *
     * @param string $text
     * @param int $length
     * @return string
     */
    public function removeFromEnd(string $text, int $length): string
    {
        return $this->removeLength($text, 0, (-1 * $length));
    }

    /*----------------------------------------*
     * Html
     *----------------------------------------*/

    /**
     * New line to br tag
     *
     * @param string $text
     * @return string
     */
    public function nl2Br(string $text): string
    {
        return str_replace(array_merge(
            ["\r\n", "\n\r", "\r", "\n"],
            [PHP_EOL]
        ), "<br \>", $text);
    }

    /**
     * Br tag to new line
     *
     * @param string $text
     * @return string
     */
    public function br2Nl(string $text): string
    {
        return preg_replace("/\<br(\s*)?\/?\>/i", PHP_EOL, $text);
    }

    /**
     * Escape html special characters
     *
     * @param string $text
     * @param string $charset
     * @param bool $doubleEncode
     * @return string
     */
    public function escape(string $text, string $charset = "UTF-8", bool $doubleEncode = true): string
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, $charset, $doubleEncode);
    }

    /**
     * Escape html special characters and convert newline code to br tag
     *
     * @param string $text
     * @param string $charset
     * @param bool $doubleEncode
     * @return string
     */
    public function enl2br(string $text, string $charset = "UTF-8", bool $doubleEncode = true): string
    {
        return $this->nl2Br($this->escape($text, $charset, $doubleEncode));
    }
}
