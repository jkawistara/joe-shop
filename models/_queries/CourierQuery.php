<?php
/**
 * CourierQuery class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_queries;

use app\models\Courier;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Courier]].
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 * @see Courier
 */
class CourierQuery extends ActiveQuery
{
    public function filterById(int $id): CourierQuery
    {
        return $this->andWhere(['id' => $id]);
    }
}
