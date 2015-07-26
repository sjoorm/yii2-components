<?php
/**
 * Created by PhpStorm.
 * @author: Alexey Tishchenko
 * @email: tischenkoalexey1@gmail.com
 * @oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * @date: 14.01.15
 */
namespace sjoorm\yii\components\exceptions;
/**
 * Class HttpException
 * @package sjoorm\yii\components\exceptions
 */
class HttpException extends \yii\web\HttpException {

    /** @inheritdoc */
    public function __construct($status, $message = null, $code = 0, \Exception $previous = null) {
        if(empty($message)) {
            switch($status) {
                case 403:
                    $message = \Yii::t('yii', 'You are not allowed to perform this action.');
                    break;
                case 404:
                    $message = \Yii::t('yii', 'No results found.');
                    break;
                default:
                    break;
            }
        }
        \yii\web\HttpException::__construct($status, $message, $code, $previous);
    }
}
