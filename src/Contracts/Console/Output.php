<?php

namespace Spark\Contracts\Console;

/**
 * Console Output Contract
 *
 * @package Spark\Contracts\Console
 */
interface Output
{
    /*----------------------------------------*
     * Text
     *----------------------------------------*/

    /**
     * get output text
     *
     * @return string
     */
    public function text(): string;

    /**
     * echo output text
     *
     * @return void
     */
    public function echo(): void;

    /**
     * echo line output text
     *
     * @return void
     */
    public function line(): void;

    /*----------------------------------------*
     * Decoration
     *----------------------------------------*/

    /**
     * add decoration
     *
     * @param int $decoration
     * @return static
     */
    public function decorate(int $decoration): static;

    /**
     * add bold decoration
     *
     * @return static
     */
    public function bold(): static;

    /**
     * add dim decoration
     *
     * @return static
     */
    public function dim(): static;

    /**
     * add italic decoration
     *
     * @return static
     */
    public function italic(): static;

    /**
     * add underline decoration
     *
     * @return static
     */
    public function underline(): static;

    /**
     * add blink decoration
     *
     * @return static
     */
    public function blink(): static;

    /**
     * add reverse decoration
     *
     * @return static
     */
    public function reverse(): static;

    /**
     * add hidden decoration
     *
     * @return static
     */
    public function hidden(): static;

    /**
     * add strikethrough decoration
     *
     * @return static
     */
    public function strikethrough(): static;

    /*----------------------------------------*
     * Text Color
     *----------------------------------------*/

    /**
     * set text color
     *
     * @param int $color
     * @return static
     */
    public function color(int $color): static;

    /**
     * set text color by 256 color code
     *
     * @param int $color
     * @return static
     */
    public function color256(int $color): static;

    /**
     * set text color by RGB values
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return static
     */
    public function rgb(int $red, int $green, int $blue): static;

    /**
     * set text color to black
     *
     * @return static
     */
    public function black(): static;

    /**
     * set text color to red
     *
     * @return static
     */
    public function red(): static;

    /**
     * set text color to green
     *
     * @return static
     */
    public function green(): static;

    /**
     * set text color to yellow
     *
     * @return static
     */
    public function yellow(): static;

    /**
     * set text color to blue
     *
     * @return static
     */
    public function blue(): static;

    /**
     * set text color to magenta
     *
     * @return static
     */
    public function magenta(): static;

    /**
     * set text color to cyan
     *
     * @return static
     */
    public function cyan(): static;

    /**
     * set text color to white
     *
     * @return static
     */
    public function white(): static;

    /**
     * set text color to default
     *
     * @return static
     */
    public function defaultColor(): static;

    /**
     * set text color to bright black
     *
     * @return static
     */
    public function brightBlack(): static;

    /**
     * set text color to bright red
     *
     * @return static
     */
    public function brightRed(): static;

    /**
     * set text color to bright green
     *
     * @return static
     */
    public function brightGreen(): static;

    /**
     * set text color to bright yellow
     *
     * @return static
     */
    public function brightYellow(): static;

    /**
     * set text color to bright blue
     *
     * @return static
     */
    public function brightBlue(): static;

    /**
     * set text color to bright magenta
     *
     * @return static
     */
    public function brightMagenta(): static;

    /**
     * set text color to bright cyan
     *
     * @return static
     */
    public function brightCyan(): static;

    /**
     * set text color to bright white
     *
     * @return static
     */
    public function brightWhite(): static;

    /*----------------------------------------*
     * Background Color
     *----------------------------------------*/

    /**
     * set background color
     *
     * @param int $color
     * @return static
     */
    public function bgColor(int $color): static;

    /**
     * set background color by 256 color code
     *
     * @param int $color
     * @return static
     */
    public function bgColor256(int $color): static;

    /**
     * set background color by RGB values
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return static
     */
    public function bgRgb(int $red, int $green, int $blue): static;

    /**
     * set background color to black
     *
     * @return static
     */
    public function bgBlack(): static;

    /**
     * set background color to red
     *
     * @return static
     */
    public function bgRed(): static;

    /**
     * set background color to green
     *
     * @return static
     */
    public function bgGreen(): static;

    /**
     * set background color to yellow
     *
     * @return static
     */
    public function bgYellow(): static;

    /**
     * set background color to blue
     *
     * @return static
     */
    public function bgBlue(): static;

    /**
     * set background color to magenta
     *
     * @return static
     */
    public function bgMagenta(): static;

    /**
     * set background color to cyan
     *
     * @return static
     */
    public function bgCyan(): static;

    /**
     * set background color to white
     *
     * @return static
     */
    public function bgWhite(): static;

    /**
     * set background color to default
     *
     * @return static
     */
    public function bgDefaultColor(): static;

    /**
     * set background color to bright black
     *
     * @return static
     */
    public function bgBrightBlack(): static;

    /**
     * set background color to bright red
     *
     * @return static
     */
    public function bgBrightRed(): static;

    /**
     * set background color to bright green
     *
     * @return static
     */
    public function bgBrightGreen(): static;

    /**
     * set background color to bright yellow
     *
     * @return static
     */
    public function bgBrightYellow(): static;

    /**
     * set background color to bright blue
     *
     * @return static
     */
    public function bgBrightBlue(): static;

    /**
     * set background color to bright magenta
     *
     * @return static
     */
    public function bgBrightMagenta(): static;

    /**
     * set background color to bright cyan
     *
     * @return static
     */
    public function bgBrightCyan(): static;

    /**
     * set background color to bright white
     *
     * @return static
     */
    public function bgBrightWhite(): static;
}
