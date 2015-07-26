<?php
/**
 * Created by PhpStorm.
 * Author: Alexey Tishchenko
 * Email: tischenkoalexey1@gmail.com
 * oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * Date: 12.11.14
 */
namespace sjoorm\yii\components\filters;
use sjoorm\yii\components\behaviors\FlagBehavior;
use yii\filters\AccessRule;
/**
 * Class FlagAccessRule implements filter rule
 * based on User (has FlagBehavior) model's "flags" column value
 * @package sjoorm\yii\components\filters
 */
class FlagAccessRule extends AccessRule {

    /** @var array flags that user should have */
    public $flags;

    /**
     * Checks if given flags (if given, of course) are set in User record
     * @param \yii\web\User $user
     * @return boolean
     */
    private function checkFlags($user) {
        $result = false;

        $identity = $user->identity;
        /** @var FlagBehavior $identity */
        if(isset($this->flags) && is_array($this->flags)) {
            foreach($this->flags as $flag) {
                if($identity->hasFlag($flag)) {
                    $result = true;
                    break;
                }
            }
        } elseif($this->flags > 0) {
            $result = $identity->hasFlag((integer)$this->flags);
        } else {
            $result = true;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function allows($action, $user, $request) {
        return parent::allows($action, $user, $request) && $this->checkFlags($user);
    }
}
