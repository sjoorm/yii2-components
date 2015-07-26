<?php
/**
 * Created by PhpStorm.
 * Author: Alexey Tishchenko
 * Email: tischenkoalexey1@gmail.com
 * oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * Date: 13.11.14
 */
namespace sjoorm\yii\widgets;
use sjoorm\yii\components\base\PageView;
use yii\base\Widget;
/**
 * Class JsData helps to transfer data from PHP to JS code
 * @package sjoorm\yii\widgets
 */
class JsData extends Widget {

    /** @var array text messages */
    public $messages = [];
    /** @var array links */
    public $urls = [];
    /** @var string custom variables */
    public $variables = [];

    /** @var string script that will be generated and inserted into the page code */
    private $script;

    /** @inheritdoc */
    public function init() {
        $yiiMessages = \Yii::$app->i18n;
        $messageSource = $yiiMessages->getMessageSource('js');
        /** @var \sjoorm\yii\components\base\PhpMessageSource $messageSource */
        $errors = $messageSource->getMessages('js');
        $dataTable = $messageSource->getMessages('dataTable');
        $this->messages = array_merge($errors, $dataTable, $this->messages);
        $this->script = 'window.pageMessages = ' . json_encode($this->messages) . ';
            window.pageUrls = ' . json_encode($this->urls) . ';
            window.pageVariables = ' . json_encode($this->variables) . ';';
    }

    /** @inheritdoc */
    public function run() {
        $this->view->registerJs($this->script, PageView::POS_BEGIN, 'jsData');
    }
}
