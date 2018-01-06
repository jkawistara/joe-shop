<?php
/**
 * CurrencyConstants class.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\common\constants;

use yii\helpers\ArrayHelper;

/**
 * CurrencyConstants.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */
class CurrencyConstants
{
    /**
     * Constant for IDR currency type.
     */
    const CURRENCY_IDR = 360;

    /**
     * Constant for SGD currency type.
     */
    const CURRENCY_SGD = 702;

    /**
     * Constant for USD currency type.
     */
    const CURRENCY_USD = 840;

    /**
     * Returns list of currency types.
     * @return integer[]
     */
    public static function getCurrencyTypes(): array
    {
        return [
            self::CURRENCY_IDR,
            self::CURRENCY_SGD,
            self::CURRENCY_USD,
        ];
    }

    /**
     * Returns list of currency type constants.
     * @return string[]
     */
    public static function getCurrencyTypeConstants(): array
    {
        return [
            self::CURRENCY_IDR => 'IDR',
            self::CURRENCY_SGD => 'SGD',
            self::CURRENCY_USD => 'USD',
        ];
    }

    /**
     * Returns currency type constant.
     * @return string
     */
    public static function getCurrencyTypeConstant(int $currency): string
    {
        return ArrayHelper::getValue(self::getCurrencyTypeConstants(), $currency, 'IDR');
    }

    /**
     * Returns list of currency type labels.
     * @return string[]
     */
    public static function getCurrencyTypeLabels(): array
    {
        return [
            self::CURRENCY_IDR => 'Rp.',
            self::CURRENCY_SGD => 'S$',
            self::CURRENCY_USD => '$',
        ];
    }

    /**
     * Returns currency type label.
     * @return string
     */
    public static function getCurrencyTypeLabel(int $currency): string
    {
        return ArrayHelper::getValue(self::getCurrencyTypeLabels(), $currency, 'Rp.');
    }

    /**
     * Returns list of currency type locales.
     * @return string[]
     */
    public static function getCurrencyTypeLocales(): array
    {
        return [
            self::CURRENCY_IDR => 'id_ID',
            self::CURRENCY_SGD => 'en_SGD',
            self::CURRENCY_USD => 'en_US',
        ];
    }

    /**
     * Returns currency type locale.
     * @return string
     */
    public static function getCurrencyTypeLocale(int $currency): string
    {
        return ArrayHelper::getValue(self::getCurrencyTypeLocales(), $currency, 'id_ID');
    }
}
