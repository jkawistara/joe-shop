<?php
/**
 * Order class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\_queries\OrderQuery;

/**
 * This is the model class for table "Order".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $productId
 * @property integer $orderedQuantity
 * @property string  $orderedDate
 *
 */
class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Orders';
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            [[
                'userId', 'productId', 'orderedQuantity', 'orderedDate'
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

    public static function find(): OrderQuery
    {
        return new OrderQuery(self::class);
    }

    /**
     * @return string[]
     */
    public static function findAllOrder(int $limit = null): array
    {
        $q = static::find();

        if(!empty($limit)){
            $q->limit($limit);
        }

        return $q->all();
    }

    public static function saveOrder(int $transactionId)
    {
        $products = Yii::$app->cart->getItems();
        $id = Yii::$app->user->identity->getId();
        $date = date('Y-m-d');
        foreach ($products as $product) {
            $order = new Order();
            $order->userId = $id;
            $order->productId = $product->id;
            $order->orderedQuantity = $product->getQuantity();
            Product::reduceQtyById($product->id,  $order->orderedQuantity);
            $order->orderedDate = $date;
            $order->save();
            Transaction::saveTransaction($transactionId, $order->id);
        }
    }
}
