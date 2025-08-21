<?php

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
     * init manager
     *
     * @return void
     */
    protected function init(): void {}

    /*----------------------------------------*
     * Convert
     *----------------------------------------*/

    /**
     * convert to pascal case
     *
     * @param string $text
     * @return string
     */
    public function toPascal(string $text): string
    {
        return str_replace(" ", "", ucwords(str_replace(["-", "_"], " ", $text)));
    }

    /**
     * convert to camel case
     *
     * @param string $text
     * @return string
     */
    public function toCamel(string $text): string
    {
        return lcfirst($this->toPascal($text));
    }

    /**
     * convert to snake case
     *
     * @param string $text
     * @return string
     */
    public function toSnake(string $text): string
    {
        return strtolower(preg_replace("/(?<!^)[A-Z]/", "_$0", $text));
    }

    /**
     * convert to kebab case
     *
     * @param string $text
     * @return string
     */
    public function toKebab(string $text): string
    {
        return str_replace("_", "-", $this->toSnake($text));
    }

    /**
     * convert to upper case
     *
     * @param string $text
     * @return string
     */
    public function toUpper(string $text): string
    {
        return strtoupper($text);
    }

    /**
     * convert to lower case
     *
     * @param string $text
     * @return string
     */
    public function toLower(string $text): string
    {
        return strtolower($text);
    }

    /**
     * convert to upper snake case
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
     * hiragana pattern
     *
     * @var string
     */
    protected string $hiragana = "ぁ-んー";

    /**
     * katakana pattern
     *
     * @var string
     */
    protected string $katakana = "ァ-ヶー";

    /**
     * kanji pattern
     *
     * @var string
     */
    protected string $kanji = "一-龠";

    /**
     * alphabet pattern
     *
     * @var string
     */
    protected string $alphabet = "a-zA-Z";

    /**
     * alphabet lower case pattern
     *
     * @var string
     */
    protected string $alphabetLower = "a-z";

    /**
     * alphabet upper case pattern
     *
     * @var string
     */
    protected string $alphabetUpper = "A-Z";

    /**
     * alphabet full width pattern
     *
     * @var string
     */
    protected string $alphabetFullWidth = "ａ-ｚＡ-Ｚ";

    /**
     * alphabet full width lower case pattern
     *
     * @var string
     */
    protected string $alphabetFullWidthLower = "ａ-ｚ";

    /**
     * alphabet full width upper case pattern
     *
     * @var string
     */
    protected string $alphabetFullWidthUpper = "Ａ-Ｚ";

    /**
     * number pattern
     *
     * @var string
     */
    protected string $number = "0-9";

    /**
     * number full width pattern
     *
     * @var string
     */
    protected string $numberFullWidth = "０-９";

    /*----------------------------------------*
     * Method
     *----------------------------------------*/

    /**
     * whether string configured only
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
     * whether string contains
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
     * whether string configured only hiragana
     *
     * @param string $text
     * @return bool
     */
    public function isHiragana(string $text): bool
    {
        return $this->is($this->hiragana, $text);
    }

    /**
     * whether string contains hiragana
     *
     * @param string $text
     * @return bool
     */
    public function hasHiragana(string $text): bool
    {
        return $this->has($this->hiragana, $text);
    }

    /**
     * whether string configured only katakana
     *
     * @param string $text
     * @return bool
     */
    public function isKatakana(string $text): bool
    {
        return $this->is($this->katakana, $text);
    }

    /**
     * whether string contains katakana
     *
     * @param string $text
     * @return bool
     */
    public function hasKatakana(string $text): bool
    {
        return $this->has($this->katakana, $text);
    }

    /**
     * whether string configured only kanji
     *
     * @param string $text
     * @return bool
     */
    public function isKanji(string $text): bool
    {
        return $this->is($this->kanji, $text);
    }

    /**
     * whether string contains kanji
     *
     * @param string $text
     * @return bool
     */
    public function hasKanji(string $text): bool
    {
        return $this->has($this->kanji, $text);
    }

    /**
     * whether string configured only alphabet
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabet(string $text): bool
    {
        return $this->is($this->alphabet, $text);
    }

    /**
     * whether string contains alphabet
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabet(string $text): bool
    {
        return $this->has($this->alphabet, $text);
    }

    /**
     * whether string configured only alphabet lower case
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetLower(string $text): bool
    {
        return $this->is($this->alphabetLower, $text);
    }

    /**
     * whether string contains alphabet lower case
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetLower(string $text): bool
    {
        return $this->has($this->alphabetLower, $text);
    }

    /**
     * whether string configured only alphabet upper case
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetUpper(string $text): bool
    {
        return $this->is($this->alphabetUpper, $text);
    }

    /**
     * whether string contains alphabet upper case
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetUpper(string $text): bool
    {
        return $this->has($this->alphabetUpper, $text);
    }

    /**
     * whether string configured only alphabet full width
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetFullWidth(string $text): bool
    {
        return $this->is($this->alphabetFullWidth, $text);
    }

    /**
     * whether string contains alphabet full width
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetFullWidth(string $text): bool
    {
        return $this->has($this->alphabetFullWidth, $text);
    }

    /**
     * whether string configured only alphabet full width lower case
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetFullWidthLower(string $text): bool
    {
        return $this->is($this->alphabetFullWidthLower, $text);
    }

    /**
     * whether string contains alphabet full width lower case
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetFullWidthLower(string $text): bool
    {
        return $this->has($this->alphabetFullWidthLower, $text);
    }

    /**
     * whether string configured only alphabet full width upper case
     *
     * @param string $text
     * @return bool
     */
    public function isAlphabetFullWidthUpper(string $text): bool
    {
        return $this->is($this->alphabetFullWidthUpper, $text);
    }

    /**
     * whether string contains alphabet full width upper case
     *
     * @param string $text
     * @return bool
     */
    public function hasAlphabetFullWidthUpper(string $text): bool
    {
        return $this->has($this->alphabetFullWidthUpper, $text);
    }

    /**
     * whether string configured only number
     *
     * @param string $text
     * @return bool
     */
    public function isNumber(string $text): bool
    {
        return $this->is($this->number, $text);
    }

    /**
     * whether string contains number
     *
     * @param string $text
     * @return bool
     */
    public function hasNumber(string $text): bool
    {
        return $this->has($this->number, $text);
    }

    /**
     * whether string configured only number full width
     *
     * @param string $text
     * @return bool
     */
    public function isNumberFullWidth(string $text): bool
    {
        return $this->is($this->numberFullWidth, $text);
    }

    /**
     * whether string contains number full width
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
     * remove
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
     * remove space
     *
     * @param string $text
     * @return string
     */
    public function removeSpace(string $text): string
    {
        return $this->remove([" ", "　"], $text);
    }

    /**
     * remove half width space
     *
     * @param string $text
     * @return string
     */
    public function removeHalfWidthSpace(string $text): string
    {
        return $this->remove(" ", $text);
    }

    /**
     * remove full width space
     *
     * @param string $text
     * @return string
     */
    public function removeFullWidthSpace(string $text): string
    {
        return $this->remove("　", $text);
    }

    /**
     * remove newline
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
     * remove tab
     *
     * @param string $text
     * @return string
     */
    public function removeTab(string $text): string
    {
        return $this->remove("\t", $text);
    }

    /**
     * remove return
     *
     * @param string $text
     * @return string
     */
    public function removeReturn(string $text): string
    {
        return $this->remove("\r", $text);
    }

    /**
     * remove by length
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
     * remove from start
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
     * remove from end
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
     * new line to br tag
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
     * br tag to new line
     *
     * @param string $text
     * @return string
     */
    public function br2Nl(string $text): string
    {
        return preg_replace("/\<br(\s*)?\/?\>/i", PHP_EOL, $text);
    }

    /**
     * escape html special characters
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
     * escape html special characters and convert newline code to br tag
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
