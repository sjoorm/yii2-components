<?php
/**
 * Created by PhpStorm.
 * Author: Alexey Tishchenko
 * Email: tischenkoalexey1@gmail.com
 * oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * Date: 12.11.14
 */
namespace sjoorm\yii\components\filters;
use Yii;
use yii\filters\AccessControl;
/**
 * Class FlagAccessControl implements filter
 * based on User (has FlagBehavior) model's "flags" column value
 * @package sjoorm\yii\components\filters
 */
class FlagAccessControl extends AccessControl {

    /** @inheritdoc */
    public $ruleConfig = ['class' => 'common\components\filters\FlagAccessRule'];

    /** @inheritdoc */
    public function beforeAction($action) {
        $user = $this->user;
        $request = Yii::$app->getRequest();
        /* @var $rule FlagAccessRule */
        foreach ($this->rules as $rule) {
            if ($allow = $rule->allows($action, $user, $request)) {
                return true;
            } else {
                if (isset($rule->denyCallback)) {
                    call_user_func($rule->denyCallback, $rule, $action);
                }
            }
        }
        if (isset($this->denyCallback)) {
            call_user_func($this->denyCallback, null, $action);
        } else {
            $this->denyAccess($user);
        }
        return false;
    }

}
