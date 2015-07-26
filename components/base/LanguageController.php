<?php
/**
 * Created by PhpStorm.
 * Author: Alexey Tishchenko
 * Email: tischenkoalexey1@gmail.com
 * oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * Date: 11.11.14
 */
namespace sjoorm\yii\components\base;
use yii\web\Controller;
use yii\web\Cookie;
/**
 * Class LanguageController implements default yii\web\Controller with language selection
 * @package sjoorm\yii\components\base
 */
class LanguageController extends Controller {

    /** @var array|string|null custom JS assets needed for this controller views */
    public $customAssetsJs;
    /** @var array|string|null custom CSS assets needed for this controller views */
    public $customAssetsCss;

    /** @inheritdoc */
    public function init() {
        $language = \Yii::$app->request->get('language', \Yii::$app->request->cookies->getValue('language'));
        if (empty($language)) {
            $language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ?
                (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4) . '-' . strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4))) :
                '';
        }
        if (
            in_array($language, \Yii::$app->params['languages'])
        ) {
            \Yii::$app->language = $language;
            \Yii::$app->response->cookies->remove('language');
            \Yii::$app->response->cookies->add(new Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 3600*24*30,
            ]));
        }

        Controller::init();
    }
}
