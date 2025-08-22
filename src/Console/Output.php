<?php

namespace Spark\Console;

use Spark\Contracts\Console\Output as OutputContract;

/**
 * Console Output
 *
 * @package Spark\Console
 */
class Output implements OutputContract
{
    /*----------------------------------------*
     * Text
     *----------------------------------------*/

    /**
     * output raw text
     *
     * @var string
     */
    protected string $text = "";

    /**
     * get output text
     *
     * @return string
     */
    public function text(): string
    {
        $decorations = implode(";", $this->decorations);
        $textColor   = implode(";", $this->textColor);
        $bgColor     = implode(";", $this->backgroundColor);

        $code = implode(";", array_filter([$decorations, $textColor, $bgColor]));

        if (empty($code)) return $this->text;

        return "\033[{$code}m{$this->text}\033[0m";
    }

    /**
     * echo output text
     *
     * @return void
     */
    public function echo(): void
    {
        echo $this->text();

        flush();
    }

    /**
     * echo line output text
     *
     * @return void
     */
    public function line(): void
    {
        echo $this->text() . PHP_EOL;

        flush();
    }

    /*----------------------------------------*
     * Decoration
     *----------------------------------------*/

    /**
     * decorations
     *
     * @var array<int>
     */
    protected array $decorations = [];

    /**
     * add decoration
     *
     * @param int $decoration
     * @return static
     */
    public function decorate(int $decoration): static
    {
        if (in_array($decoration, $this->decorations)) return $this;

        $this->decorations[] = $decoration;

        return $this;
    }

    /**
     * add bold decoration
     *
     * @return static
     */
    public function bold(): static
    {
        return $this->decorate(1);
    }

    /**
     * add dim decoration
     *
     * @return static
     */
    public function dim(): static
    {
        return $this->decorate(2);
    }

    /**
     * add italic decoration
     *
     * @return static
     */
    public function italic(): static
    {
        return $this->decorate(3);
    }

    /**
     * add underline decoration
     *
     * @return static
     */
    public function underline(): static
    {
        return $this->decorate(4);
    }

    /**
     * add blink decoration
     *
     * @return static
     */
    public function blink(): static
    {
        return $this->decorate(5);
    }

    /**
     * add reverse decoration
     *
     * @return static
     */
    public function reverse(): static
    {
        return $this->decorate(7);
    }

    /**
     * add hidden decoration
     *
     * @return static
     */
    public function hidden(): static
    {
        return $this->decorate(8);
    }

    /**
     * add strikethrough decoration
     *
     * @return static
     */
    public function strikethrough(): static
    {
        return $this->decorate(9);
    }

    /*----------------------------------------*
     * Text Color
     *----------------------------------------*/

    /**
     * text color
     *
     * @var array<int>
     */
    protected array $textColor = [];

    /**
     * set text color
     *
     * @param int $color
     * @return static
     */
    public function color(int $color): static
    {
        $this->textColor = [$color];

        return $this;
    }

    /**
     * set text color by 256 color code
     *
     * @param int $color
     * @return static
     */
    public function color256(int $color): static
    {
        $this->textColor = [38, 5, $color];

        return $this;
    }

    /**
     * set text color by RGB values
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return static
     */
    public function rgb(int $red, int $green, int $blue): static
    {
        $this->textColor = [38, 2, $red, $green, $blue];

        return $this;
    }

    /**
     * set text color to black
     *
     * @return static
     */
    public function black(): static
    {
        return $this->color(30);
    }

    /**
     * set text color to red
     *
     * @return static
     */
    public function red(): static
    {
        return $this->color(31);
    }

    /**
     * set text color to green
     *
     * @return static
     */
    public function green(): static
    {
        return $this->color(32);
    }

    /**
     * set text color to yellow
     *
     * @return static
     */
    public function yellow(): static
    {
        return $this->color(33);
    }

    /**
     * set text color to blue
     *
     * @return static
     */
    public function blue(): static
    {
        return $this->color(34);
    }

    /**
     * set text color to magenta
     *
     * @return static
     */
    public function magenta(): static
    {
        return $this->color(35);
    }

    /**
     * set text color to cyan
     *
     * @return static
     */
    public function cyan(): static
    {
        return $this->color(36);
    }

    /**
     * set text color to white
     *
     * @return static
     */
    public function white(): static
    {
        return $this->color(37);
    }

    /**
     * set text color to default
     *
     * @return static
     */
    public function defaultColor(): static
    {
        return $this->color(39);
    }

    /**
     * set text color to bright black
     *
     * @return static
     */
    public function brightBlack(): static
    {
        return $this->color(90);
    }

    /**
     * set text color to bright red
     *
     * @return static
     */
    public function brightRed(): static
    {
        return $this->color(91);
    }

    /**
     * set text color to bright green
     *
     * @return static
     */
    public function brightGreen(): static
    {
        return $this->color(92);
    }

    /**
     * set text color to bright yellow
     *
     * @return static
     */
    public function brightYellow(): static
    {
        return $this->color(93);
    }

    /**
     * set text color to bright blue
     *
     * @return static
     */
    public function brightBlue(): static
    {
        return $this->color(94);
    }

    /**
     * set text color to bright magenta
     *
     * @return static
     */
    public function brightMagenta(): static
    {
        return $this->color(95);
    }

    /**
     * set text color to bright cyan
     *
     * @return static
     */
    public function brightCyan(): static
    {
        return $this->color(96);
    }

    /**
     * set text color to bright white
     *
     * @return static
     */
    public function brightWhite(): static
    {
        return $this->color(97);
    }

    /*----------------------------------------*
     * Background Color
     *----------------------------------------*/

    /**
     * background color
     *
     * @var array<int>
     */
    protected array $backgroundColor = [];

    /**
     * set background color
     *
     * @param int $color
     * @return static
     */
    public function bgColor(int $color): static
    {
        $this->backgroundColor = [$color];

        return $this;
    }

    /**
     * set background color by 256 color code
     *
     * @param int $color
     * @return static
     */
    public function bgColor256(int $color): static
    {
        $this->backgroundColor = [48, 5, $color];

        return $this;
    }

    /**
     * set background color by RGB values
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return static
     */
    public function bgRgb(int $red, int $green, int $blue): static
    {
        $this->backgroundColor = [48, 2, $red, $green, $blue];

        return $this;
    }

    /**
     * set background color to black
     *
     * @return static
     */
    public function bgBlack(): static
    {
        return $this->bgColor(40);
    }

    /**
     * set background color to red
     *
     * @return static
     */
    public function bgRed(): static
    {
        return $this->bgColor(41);
    }

    /**
     * set background color to green
     *
     * @return static
     */
    public function bgGreen(): static
    {
        return $this->bgColor(42);
    }

    /**
     * set background color to yellow
     *
     * @return static
     */
    public function bgYellow(): static
    {
        return $this->bgColor(43);
    }

    /**
     * set background color to blue
     *
     * @return static
     */
    public function bgBlue(): static
    {
        return $this->bgColor(44);
    }

    /**
     * set background color to magenta
     *
     * @return static
     */
    public function bgMagenta(): static
    {
        return $this->bgColor(45);
    }

    /**
     * set background color to cyan
     *
     * @return static
     */
    public function bgCyan(): static
    {
        return $this->bgColor(46);
    }

    /**
     * set background color to white
     *
     * @return static
     */
    public function bgWhite(): static
    {
        return $this->bgColor(47);
    }

    /**
     * set background color to default
     *
     * @return static
     */
    public function bgDefaultColor(): static
    {
        return $this->bgColor(49);
    }

    /**
     * set background color to bright black
     *
     * @return static
     */
    public function bgBrightBlack(): static
    {
        return $this->bgColor(100);
    }

    /**
     * set background color to bright red
     *
     * @return static
     */
    public function bgBrightRed(): static
    {
        return $this->bgColor(101);
    }

    /**
     * set background color to bright green
     *
     * @return static
     */
    public function bgBrightGreen(): static
    {
        return $this->bgColor(102);
    }

    /**
     * set background color to bright yellow
     *
     * @return static
     */
    public function bgBrightYellow(): static
    {
        return $this->bgColor(103);
    }

    /**
     * set background color to bright blue
     *
     * @return static
     */
    public function bgBrightBlue(): static
    {
        return $this->bgColor(104);
    }

    /**
     * set background color to bright magenta
     *
     * @return static
     */
    public function bgBrightMagenta(): static
    {
        return $this->bgColor(105);
    }

    /**
     * set background color to bright cyan
     *
     * @return static
     */
    public function bgBrightCyan(): static
    {
        return $this->bgColor(106);
    }

    /**
     * set background color to bright white
     *
     * @return static
     */
    public function bgBrightWhite(): static
    {
        return $this->bgColor(107);
    }
}
