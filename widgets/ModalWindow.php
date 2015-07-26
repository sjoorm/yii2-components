<?php
/**
 * @author Alexey Tishchenko <tischenkoalexey1@gmail.com>
 * @oDesk https://www.odesk.com/users/~01ad7ed1a6ade4e02e 
 * @website https://sjoorm.com
 * date: 2014-06-26
 */
namespace sjoorm\yii\widgets;
use yii\base\Widget;
/**
 * Class ModalWindow implements basic modal window used app-widely for simple notifications
 * @package sjoorm\yii\widgets
 */
class ModalWindow extends Widget {

    const CSS = '/modalWindow.css';
    const PATH = 'assets/modalWindow';

    /** @var string translation sources for 'close' button text */
    public $translations = 'common';

    /** @var string widget dir */
    protected $dir = __DIR__;

    /** @inheritdoc */
    public function run() {
        $this->view->registerCss(
            'div.modal-dialog{z-index: 11000;}',
            [],
            'modalWindow'
        );
        return $this->render('modalWindow', [
            'close' => \Yii::t('common', 'close'),
        ]);
    }
}
