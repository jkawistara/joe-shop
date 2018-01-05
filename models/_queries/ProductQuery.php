<?php
/**
 * ProductQuery class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_queries;

use app\models\Product;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Product]].
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 * @see Product
 */
class ProductQuery extends ActiveQuery
{
    public function filterById(int $id): ProductQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    public function filterByQuantityMoreThan(int $number): ProductQuery
    {
        return $this->andWhere(['>=', 'quantity', $number]);
    }

    public function sortByMostExpensiveCost(float $cost): ProductQuery
    {
        return $this->orderBy(['cost' => SORT_DESC]);
    }

    public function sortByCheapestCost(float $cost): ProductQuery
    {
        return $this->orderBy(['cost' => SORT_ASC]);
    }
}
