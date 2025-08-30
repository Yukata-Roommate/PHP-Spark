<?php

declare(strict_types=1);

namespace Spark\Console;

use Spark\Contracts\Console\Output as OutputContract;

use Spark\Exceptions\Console\ColorCodeException;
use Spark\Exceptions\Console\RgbValueException;
use Spark\Exceptions\Console\DecorationException;

/**
 * Console Output
 *
 * @package Spark\Console
 */
class Output implements OutputContract
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     *
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /*----------------------------------------*
     * Text
     *----------------------------------------*/

    /**
     * Output raw text
     *
     * @var string
     */
    protected string $text;

    /**
     * {@inheritDoc}
     */
    public function text(): string
    {
        if (!$this->isAnsiSupported()) return $this->text;

        $decorations = implode(";", $this->decorations);
        $textColor   = implode(";", $this->textColor);
        $bgColor     = implode(";", $this->backgroundColor);

        $code = implode(";", array_filter([$decorations, $textColor, $bgColor]));

        if (empty($code)) return $this->text;

        return "\033[{$code}m{$this->text}\033[0m";
    }

    /**
     * {@inheritDoc}
     */
    public function echo(): void
    {
        echo $this->text();

        flush();
    }

    /**
     * {@inheritDoc}
     */
    public function line(): void
    {
        echo $this->text() . PHP_EOL;

        flush();
    }

    /**
     * Check if ANSI codes are supported
     *
     * @return bool
     */
    protected function isAnsiSupported(): bool
    {
        if (DIRECTORY_SEPARATOR === "\\") {
            return getenv("ANSICON") !== false
                || getenv("ConEmuANSI") === "ON"
                || getenv("TERM_PROGRAM") === "vscode"
                || (function_exists("sapi_windows_vt100_support") && sapi_windows_vt100_support(STDOUT));
        }

        return function_exists("posix_isatty") && posix_isatty(STDOUT);
    }

    /*----------------------------------------*
     * Decoration
     *----------------------------------------*/

    /**
     * Active decorations
     *
     * @var array<int>
     */
    protected array $decorations = [];

    /**
     * Valid ANSI decoration codes
     *
     * @var array<int>
     */
    protected array $validDecorations = [1, 2, 3, 4, 5, 7, 8, 9];

    /**
     * {@inheritDoc}
     */
    public function decorate(int $decoration): static
    {
        if (!in_array($decoration, $this->validDecorations)) throw new DecorationException($decoration);

        if (in_array($decoration, $this->decorations)) return $this;

        $this->decorations[] = $decoration;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function bold(): static
    {
        return $this->decorate(1);
    }

    /**
     * {@inheritDoc}
     */
    public function dim(): static
    {
        return $this->decorate(2);
    }

    /**
     * {@inheritDoc}
     */
    public function italic(): static
    {
        return $this->decorate(3);
    }

    /**
     * {@inheritDoc}
     */
    public function underline(): static
    {
        return $this->decorate(4);
    }

    /**
     * {@inheritDoc}
     */
    public function blink(): static
    {
        return $this->decorate(5);
    }

    /**
     * {@inheritDoc}
     */
    public function reverse(): static
    {
        return $this->decorate(7);
    }

    /**
     * {@inheritDoc}
     */
    public function hidden(): static
    {
        return $this->decorate(8);
    }

    /**
     * {@inheritDoc}
     */
    public function strikethrough(): static
    {
        return $this->decorate(9);
    }

    /*----------------------------------------*
     * Color
     *----------------------------------------*/

    /**
     * Valid 256 color min
     *
     * @var int
     */
    protected int $color256Min = 0;

    /**
     * Valid 256 color max
     *
     * @var int
     */
    protected int $color256Max = 255;

    /**
     * Valid RGB value min
     *
     * @var int
     */
    protected int $rgbMin = 0;

    /**
     * Valid RGB value max
     *
     * @var int
     */
    protected int $rgbMax = 255;

    /**
     * Validate 256 color code
     *
     * @param int $color
     * @return void
     * @throws \Spark\Exceptions\Console\ColorCodeException
     */
    protected function validateColor256(int $color): void
    {
        if ($color < $this->color256Min || $color > $this->color256Max) throw new ColorCodeException($color, $this->color256Min, $this->color256Max);
    }

    /**
     * Validate RGB value
     *
     * @param string $colorName
     * @param int $color
     * @return void
     * @throws \Spark\Exceptions\Console\RgbValueException
     */
    protected function validateRgbValue(string $colorName, int $color): void
    {
        if ($color < $this->rgbMin || $color > $this->rgbMax) throw new RgbValueException($colorName, $color, $this->rgbMin, $this->rgbMax);
    }

    /*----------------------------------------*
     * Text Color
     *----------------------------------------*/

    /**
     * Text color
     *
     * @var array<int>
     */
    protected array $textColor = [];

    /**
     * {@inheritDoc}
     */
    public function color(int $color): static
    {
        $this->textColor = [$color];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function color256(int $color): static
    {
        $this->validateColor256($color);

        $this->textColor = [38, 5, $color];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function rgb(int $red, int $green, int $blue): static
    {
        $this->validateRgbValue("Red", $red);
        $this->validateRgbValue("Green", $green);
        $this->validateRgbValue("Blue", $blue);

        $this->textColor = [38, 2, $red, $green, $blue];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function black(): static
    {
        return $this->color(30);
    }

    /**
     * {@inheritDoc}
     */
    public function red(): static
    {
        return $this->color(31);
    }

    /**
     * {@inheritDoc}
     */
    public function green(): static
    {
        return $this->color(32);
    }

    /**
     * {@inheritDoc}
     */
    public function yellow(): static
    {
        return $this->color(33);
    }

    /**
     * {@inheritDoc}
     */
    public function blue(): static
    {
        return $this->color(34);
    }

    /**
     * {@inheritDoc}
     */
    public function magenta(): static
    {
        return $this->color(35);
    }

    /**
     * {@inheritDoc}
     */
    public function cyan(): static
    {
        return $this->color(36);
    }

    /**
     * {@inheritDoc}
     */
    public function white(): static
    {
        return $this->color(37);
    }

    /**
     * {@inheritDoc}
     */
    public function defaultColor(): static
    {
        return $this->color(39);
    }

    /**
     * {@inheritDoc}
     */
    public function brightBlack(): static
    {
        return $this->color(90);
    }

    /**
     * {@inheritDoc}
     */
    public function brightRed(): static
    {
        return $this->color(91);
    }

    /**
     * {@inheritDoc}
     */
    public function brightGreen(): static
    {
        return $this->color(92);
    }

    /**
     * {@inheritDoc}
     */
    public function brightYellow(): static
    {
        return $this->color(93);
    }

    /**
     * {@inheritDoc}
     */
    public function brightBlue(): static
    {
        return $this->color(94);
    }

    /**
     * {@inheritDoc}
     */
    public function brightMagenta(): static
    {
        return $this->color(95);
    }

    /**
     * {@inheritDoc}
     */
    public function brightCyan(): static
    {
        return $this->color(96);
    }

    /**
     * {@inheritDoc}
     */
    public function brightWhite(): static
    {
        return $this->color(97);
    }

    /*----------------------------------------*
     * Background Color
     *----------------------------------------*/

    /**
     * Background color
     *
     * @var array<int>
     */
    protected array $backgroundColor = [];

    /**
     * {@inheritDoc}
     */
    public function bgColor(int $color): static
    {
        $this->backgroundColor = [$color];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function bgColor256(int $color): static
    {
        $this->validateColor256($color);

        $this->backgroundColor = [48, 5, $color];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function bgRgb(int $red, int $green, int $blue): static
    {
        $this->validateRgbValue("Red", $red);
        $this->validateRgbValue("Green", $green);
        $this->validateRgbValue("Blue", $blue);

        $this->backgroundColor = [48, 2, $red, $green, $blue];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function bgBlack(): static
    {
        return $this->bgColor(40);
    }

    /**
     * {@inheritDoc}
     */
    public function bgRed(): static
    {
        return $this->bgColor(41);
    }

    /**
     * {@inheritDoc}
     */
    public function bgGreen(): static
    {
        return $this->bgColor(42);
    }

    /**
     * {@inheritDoc}
     */
    public function bgYellow(): static
    {
        return $this->bgColor(43);
    }

    /**
     * {@inheritDoc}
     */
    public function bgBlue(): static
    {
        return $this->bgColor(44);
    }

    /**
     * {@inheritDoc}
     */
    public function bgMagenta(): static
    {
        return $this->bgColor(45);
    }

    /**
     * {@inheritDoc}
     */
    public function bgCyan(): static
    {
        return $this->bgColor(46);
    }

    /**
     * {@inheritDoc}
     */
    public function bgWhite(): static
    {
        return $this->bgColor(47);
    }

    /**
     * {@inheritDoc}
     */
    public function bgDefaultColor(): static
    {
        return $this->bgColor(49);
    }

    /**
     * {@inheritDoc}
     */
    public function bgBrightBlack(): static
    {
        return $this->bgColor(100);
    }

    /**
     * {@inheritDoc}
     */
    public function bgBrightRed(): static
    {
        return $this->bgColor(101);
    }

    /**
     * {@inheritDoc}
     */
    public function bgBrightGreen(): static
    {
        return $this->bgColor(102);
    }

    /**
     * {@inheritDoc}
     */
    public function bgBrightYellow(): static
    {
        return $this->bgColor(103);
    }

    /**
     * {@inheritDoc}
     */
    public function bgBrightBlue(): static
    {
        return $this->bgColor(104);
    }

    /**
     * {@inheritDoc}
     */
    public function bgBrightMagenta(): static
    {
        return $this->bgColor(105);
    }

    /**
     * {@inheritDoc}
     */
    public function bgBrightCyan(): static
    {
        return $this->bgColor(106);
    }

    /**
     * {@inheritDoc}
     */
    public function bgBrightWhite(): static
    {
        return $this->bgColor(107);
    }
}
