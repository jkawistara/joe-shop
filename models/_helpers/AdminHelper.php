<?php
/**
 * AdminHelper class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */

namespace app\models\_helpers;

use Yii;
use app\models\Role;

/**
 * AdminHelper class file.
 * @author Jauhari Khairul Kawistara <jkawistara@gmail.com>
 */
class AdminHelper
{

    public static function isAdmin()
    {
        $params = Yii::$app->params;
        return !Role::isUser() && key_exists(Role::ROLE_ADMIN, $params) && $params['admin'] === true;
    }
}
