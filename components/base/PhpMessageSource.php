<?php
/**
 * Created by PhpStorm.
 * Author: Alexey Tishchenko
 * Email: tischenkoalexey1@gmail.com
 * oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * Date: 13.11.14
 */
namespace common\components\base;
/**
 * Class PhpMessageSource adds necessary functionality to base class
 * for JsData widget
 * @package common\components\base
 */
class PhpMessageSource extends \yii\i18n\PhpMessageSource {

    /**
     * Gets all translated messages from specified category
     * @param string $category
     * @return array
     */
    public function getMessages($category) {
        return $this->loadMessages($category, \Yii::$app->language);
    }
}
