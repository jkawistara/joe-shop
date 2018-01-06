<?php
/**
 * Formatter class file
 * @package common\formatter
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace common\formatter;

/**
 * Class Formatter
 * @package common\formatter
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */
class Formatter extends \yii\i18n\Formatter
{

    const PERCENTAGE_DECIMAL = 2;

    /**
     * @param mixed          $value       The value.
     * @param integer | null $currency    The currency.
     * @param string[]       $options     The options.
     * @param string[]       $textOptions The text options.
     */
    public function asCurrency($value, $currency = null, $options = [], $textOptions = []): string
    {
        $options;
        $textOptions;
        return $currency. ' ' . $this->asInteger($value);
    }

    /**
     * @param mixed          $value       The value.
     * @param integer | null $currency    The currency.
     * @param string[]       $options     The options.
     * @param string[]       $textOptions The text options.
     */
    public function asPercent($value, $decimals = self::PERCENTAGE_DECIMAL, $options = [], $textOptions = []): string
    {
        $options;
        $textOptions;
        $value *= 100;
        return number_format($value, $decimals, $this->decimalSeparator, $this->thousandSeparator) . ' %';
    }
}
