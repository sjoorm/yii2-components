<?php
/**
 * Created by PhpStorm.
 * Author: Alexey Tishchenko
 * Email: tischenkoalexey1@gmail.com
 * oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * Date: 10.11.14
 */
namespace sjoorm\yii\components\behaviors;
use yii\web\Response;
/**
 * Trait JsonControllerBehavior helps to send JSON responses
 * @package sjoorm\yii\components\behaviors
 */
trait JsonControllerBehavior {

    /** @var integer HTTP status code */
    public $code = 200;
    /** @var bool status of request */
    public $success = false;
    /** @var string|null response message */
    public $message;
    /** @var mixed custom response data */
    public $data = [];

    /**
     * Renders JSON encoded output with correct HTTP headers
     * @param mixed|null
     * @return string
     */
    public function renderJson($response = null) {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        \Yii::$app->response->statusCode = $this->code;

        $response = isset($response) ? $response : array_merge([
            'code' => $this->code,
            'success' => $this->success,
            'message' => $this->message,
        ], $this->data);

        return $response;
    }
}
