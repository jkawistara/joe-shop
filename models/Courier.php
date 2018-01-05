<?php
/**
 * Courier class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\_queries\CourierQuery;

/**
 * This is the model class for table "Courier".
 *
 * @property integer $id
 * @property string $name
 */
class Courier extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Couriers';
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            [[
                'name'
            ], 'required'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common/labels', 'ID'),
        ];
    }

    public static function find(): CourierQuery
    {
        return new CourierQuery(self::class);
    }

    /**
     * @return string[]
     */
    public static function findAllCourier(int $limit = null): array
    {
        $q = static::find();

        if(!empty($limit)){
            $q->limit($limit);
        }

        return $q->all();
    }
}
