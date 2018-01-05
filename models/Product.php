<?php
/**
 * Product class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use hscstudio\cart\ItemTrait;
use app\models\_queries\ProductQuery;

/**
 * This is the model class for table "Product".
 *
 * @property integer $id
 * @property string  $name
 * @property integer $quantity
 * @property float   $cost
 * @property float   $price
 * @property string  $source
 *
 */
class Product extends ActiveRecord
{
    use ItemTrait;

    const DEFAULT_QTY = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Products';
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            [[
                'name', 'quantity', 'cost', 'price', 'source'
            ], 'required'],
            [[
                'cost', 'price'
            ], 'number'],
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

    public static function find(): ProductQuery
    {
        return new ProductQuery(self::class);
    }

    /**
     * @return string[]
     */
    public static function findAllProduct(int $limit = null): array
    {
        $q = static::find();

        if(!empty($limit)){
            $q->limit($limit);
        }

        return $q->all();
    }

    /**
     * @return string[]
     */
    public static function findProducts(int $limit = null): array
    {
        $products = static::findAllProduct($limit);
        $cart = Yii::$app->cart->getItems();
        if (!empty($cart)) {
            return $products;
        }
        foreach ($products as $product) {
            Yii::$app->session->set("product-{$product->id}", $product->quantity);
        }

        return $products;
    }

    public static function destroySessionProducts()
    {
        $products = static::findAllProduct();
        foreach ($products as $product) {
            Yii::$app->session->remove("product-{$product->id}");
        }
    }

    public static function findById(int $id): Product
    {
        return static::find()
            ->filterById($id)
            ->one();
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function reduceQtyById(int $id, int $quantity)
    {
        $products = self::findById($id);
        $products->quantity -= $quantity;
        $products->save();
    }
}
