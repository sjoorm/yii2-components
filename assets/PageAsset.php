<?php
/**
 * Created by PhpStorm.
 * @author: Alexey Tishchenko
 * @email: tischenkoalexey1@gmail.com
 * @oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * @date: 04.12.14
 */
namespace sjoorm\yii\assets;
use yii\web\AssetBundle;
/**
 * Class PageAsset implements assets containing page-specific files
 * @package sjoorm\yii\assets
 */
class PageAsset extends AssetBundle {

    /** @inheritdoc */
    public $basePath = '@webroot';
    /** @inheritdoc */
    public $baseUrl = '@web';

    /** @inheritdoc */
    public function init() {
        $controller = \Yii::$app->controller->id;
        $action = \Yii::$app->controller->action->id;
        $path = \Yii::getAlias($this->basePath);
        $jsAction = "js/$controller/$action.js";
        $cssAction = "css/$controller/$action.css";
        $jsController = "js/$controller.js";
        $cssController = "css/$controller.css";
        if(file_exists("$path/$jsAction")) {
            $this->js[] = $jsAction;
        }
        if(file_exists("$path/$jsController")) {
            $this->js[] = $jsController;
        }
        if(file_exists("$path/$cssAction")) {
            $this->css[] = $cssAction;
        }
        if(file_exists("$path/$cssController")) {
            $this->css[] = $cssController;
        }
        if(isset(\Yii::$app->controller->customAssetsJs) && \Yii::$app->controller->customAssetsJs) {
            if(is_array(\Yii::$app->controller->customAssetsJs)) {
                $this->js = array_merge($this->js, \Yii::$app->controller->customAssetsJs);
            } else {
                $this->js[] = \Yii::$app->controller->customAssetsJs;
            }
        }
        if(isset(\Yii::$app->controller->customAssetsCss) && \Yii::$app->controller->customAssetsCss) {
            if(is_array(\Yii::$app->controller->customAssetsCss)) {
                $this->css = array_merge($this->css, \Yii::$app->controller->customAssetsCss);
            } else {
                $this->css[] = \Yii::$app->controller->customAssetsCss;
            }
        }

        parent::init();
    }
}
