<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\TextManager;

/**
 * Text Proxy
 *
 * @package Spark\Proxies
 *
 * @method static string toPascal(string $text)
 * @method static string toCamel(string $text)
 * @method static string toSnake(string $text)
 * @method static string toKebab(string $text)
 * @method static string toUpper(string $text)
 * @method static string toLower(string $text)
 * @method static string toUpperSnake(string $text)
 *
 * @method static bool is(string $pattern, string $text)
 * @method static bool has(string $pattern, string $text)
 * @method static bool isHiragana(string $text)
 * @method static bool hasHiragana(string $text)
 * @method static bool isKatakana(string $text)
 * @method static bool hasKatakana(string $text)
 * @method static bool isKanji(string $text)
 * @method static bool hasKanji(string $text)
 * @method static bool isAlphabet(string $text)
 * @method static bool hasAlphabet(string $text)
 * @method static bool isAlphabetLower(string $text)
 * @method static bool hasAlphabetLower(string $text)
 * @method static bool isAlphabetUpper(string $text)
 * @method static bool hasAlphabetUpper(string $text)
 * @method static bool isAlphabetFullWidth(string $text)
 * @method static bool hasAlphabetFullWidth(string $text)
 * @method static bool isAlphabetFullWidthLower(string $text)
 * @method static bool hasAlphabetFullWidthLower(string $text)
 * @method static bool isAlphabetFullWidthUpper(string $text)
 * @method static bool hasAlphabetFullWidthUpper(string $text)
 * @method static bool isNumber(string $text)
 * @method static bool hasNumber(string $text)
 * @method static bool isNumberFullWidth(string $text)
 * @method static bool hasNumberFullWidth(string $text)
 *
 * @method static string remove($search, string $text)
 * @method static string removeSpace(string $text)
 * @method static string removeHalfWidthSpace(string $text)
 * @method static string removeFullWidthSpace(string $text)
 * @method static string removeNewline(string $text)
 * @method static string removeTab(string $text)
 * @method static string removeReturn(string $text)
 * @method static string removeLength(string $text, int $start, int $length)
 * @method static string removeFromStart(string $text, int $length)
 * @method static string removeFromEnd(string $text, int $length)
 *
 * @method static string nl2Br(string $text)
 * @method static string br2Nl(string $text)
 * @method static string escape(string $text, string $charset = "UTF-8", bool $doubleEncode = true)
 * @method static string enl2br(string $text, string $charset = "UTF-8", bool $doubleEncode = true)
 *
 * @see \Spark\Proxies\Managers\TextManager
 */
class Text extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = TextManager::class;
}
