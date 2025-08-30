<?php

declare(strict_types=1);

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
     * Get formatted output text with ANSI codes
     *
     * @return string
     */
    public function text(): string;

    /**
     * Echo output text without newline
     *
     * @return void
     */
    public function echo(): void;

    /**
     * Echo output text with newline
     *
     * @return void
     */
    public function line(): void;

    /*----------------------------------------*
     * Decoration
     *----------------------------------------*/

    /**
     * Add decoration to output
     *
     * @param int $decoration
     * @return static
     * @throws \Spark\Exceptions\Console\DecorationException
     */
    public function decorate(int $decoration): static;

    /**
     * Add bold decoration
     *
     * @return static
     */
    public function bold(): static;

    /**
     * Add dim decoration
     *
     * @return static
     */
    public function dim(): static;

    /**
     * Add italic decoration
     *
     * @return static
     */
    public function italic(): static;

    /**
     * Add underline decoration
     *
     * @return static
     */
    public function underline(): static;

    /**
     * Add blink decoration
     *
     * @return static
     */
    public function blink(): static;

    /**
     * Add reverse decoration
     *
     * @return static
     */
    public function reverse(): static;

    /**
     * Add hidden decoration
     *
     * @return static
     */
    public function hidden(): static;

    /**
     * Add strikethrough decoration
     *
     * @return static
     */
    public function strikethrough(): static;

    /*----------------------------------------*
     * Text Color
     *----------------------------------------*/

    /**
     * Set text color using ANSI code
     *
     * @param int $color
     * @return static
     */
    public function color(int $color): static;

    /**
     * Set text color using 256 color palette
     *
     * @param int $color
     * @return static
     * @throws \Spark\Exceptions\Console\ColorCodeException
     */
    public function color256(int $color): static;

    /**
     * Set text color using RGB values
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return static
     * @throws \Spark\Exceptions\Console\RgbValueException
     */
    public function rgb(int $red, int $green, int $blue): static;

    /**
     * Set text color to black
     *
     * @return static
     */
    public function black(): static;

    /**
     * Set text color to red
     *
     * @return static
     */
    public function red(): static;

    /**
     * Set text color to green
     *
     * @return static
     */
    public function green(): static;

    /**
     * Set text color to yellow
     *
     * @return static
     */
    public function yellow(): static;

    /**
     * Set text color to blue
     *
     * @return static
     */
    public function blue(): static;

    /**
     * Set text color to magenta
     *
     * @return static
     */
    public function magenta(): static;

    /**
     * Set text color to cyan
     *
     * @return static
     */
    public function cyan(): static;

    /**
     * Set text color to white
     *
     * @return static
     */
    public function white(): static;

    /**
     * Set text color to default
     *
     * @return static
     */
    public function defaultColor(): static;

    /**
     * Set text color to bright black
     *
     * @return static
     */
    public function brightBlack(): static;

    /**
     * Set text color to bright red
     *
     * @return static
     */
    public function brightRed(): static;

    /**
     * Set text color to bright green
     *
     * @return static
     */
    public function brightGreen(): static;

    /**
     * Set text color to bright yellow
     *
     * @return static
     */
    public function brightYellow(): static;

    /**
     * Set text color to bright blue
     *
     * @return static
     */
    public function brightBlue(): static;

    /**
     * Set text color to bright magenta
     *
     * @return static
     */
    public function brightMagenta(): static;

    /**
     * Set text color to bright cyan
     *
     * @return static
     */
    public function brightCyan(): static;

    /**
     * Set text color to bright white
     *
     * @return static
     */
    public function brightWhite(): static;

    /*----------------------------------------*
     * Background Color
     *----------------------------------------*/

    /**
     * Set background color using ANSI code
     *
     * @param int $color
     * @return static
     */
    public function bgColor(int $color): static;

    /**
     * Set background color using 256 color palette
     *
     * @param int $color
     * @return static
     * @throws \Spark\Exceptions\Console\ColorCodeException
     */
    public function bgColor256(int $color): static;

    /**
     * Set background color using RGB values
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return static
     * @throws \Spark\Exceptions\Console\RgbValueException
     */
    public function bgRgb(int $red, int $green, int $blue): static;

    /**
     * Set background color to black
     *
     * @return static
     */
    public function bgBlack(): static;

    /**
     * Set background color to red
     *
     * @return static
     */
    public function bgRed(): static;

    /**
     * Set background color to green
     *
     * @return static
     */
    public function bgGreen(): static;

    /**
     * Set background color to yellow
     *
     * @return static
     */
    public function bgYellow(): static;

    /**
     * Set background color to blue
     *
     * @return static
     */
    public function bgBlue(): static;

    /**
     * Set background color to magenta
     *
     * @return static
     */
    public function bgMagenta(): static;

    /**
     * Set background color to cyan
     *
     * @return static
     */
    public function bgCyan(): static;

    /**
     * Set background color to white
     *
     * @return static
     */
    public function bgWhite(): static;

    /**
     * Set background color to default
     *
     * @return static
     */
    public function bgDefaultColor(): static;

    /**
     * Set background color to bright black
     *
     * @return static
     */
    public function bgBrightBlack(): static;

    /**
     * Set background color to bright red
     *
     * @return static
     */
    public function bgBrightRed(): static;

    /**
     * Set background color to bright green
     *
     * @return static
     */
    public function bgBrightGreen(): static;

    /**
     * Set background color to bright yellow
     *
     * @return static
     */
    public function bgBrightYellow(): static;

    /**
     * Set background color to bright blue
     *
     * @return static
     */
    public function bgBrightBlue(): static;

    /**
     * Set background color to bright magenta
     *
     * @return static
     */
    public function bgBrightMagenta(): static;

    /**
     * Set background color to bright cyan
     *
     * @return static
     */
    public function bgBrightCyan(): static;

    /**
     * Set background color to bright white
     *
     * @return static
     */
    public function bgBrightWhite(): static;
}
