<?php
/**
 * Created by PhpStorm.
 * @author: Alexey Tishchenko
 * @email: tischenkoalexey1@gmail.com
 * @oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * @date: 21.05.15
 */
namespace sjoorm\yii\components\base;
use sjoorm\yii\assets\PageAsset;
use yii\base\Event;
use yii\web\View;
/**
 * Class PageView implements basic View with JS data variables
 * @package sjoorm\yii\components\base
 */
class PageView extends View {

    /** @var string messages source to translate titles */
    public $translations = 'titles';
    /** @var string will appear in the Title widget */
    public $subTitle;
    /** @var array messages used in JS code */
    public $jsMessages = [];
    /** @var array URLs used in JS code */
    public $jsUrls = [];
    /** @var array variables used in JS code */
    public $jsVariables = [];

    /** @inheritdoc */
    public function render($view, $params = [], $context = null) {
        /** assign page titles */
        if(!isset($this->title)) {
            $this->title = \Yii::t($this->translations, ucfirst(\Yii::$app->controller->id));
        }
        if(!isset($this->subTitle)) {
            $this->subTitle = \Yii::t($this->translations, ucfirst(\Yii::$app->controller->action->id));
        }

        /** Create an event handler to register page asset as a last one */
        $this->on(self::EVENT_END_BODY, function($event) {
            /** @var Event $event */
            $sender = $event->sender;
            /** @var self $sender */
            PageAsset::register($sender);
        });

        return parent::render($view, $params, $context);
    }
}
