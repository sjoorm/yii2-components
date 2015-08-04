<?php
/**
 * Created by PhpStorm.
 * @author: Alexey Tishchenko
 * @email: tischenkoalexey1@gmail.com
 * @oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * @date: 04.08.15
 */
namespace sjoorm\yii\widgets;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveField;
/**
 * Class HorizontalActiveField implements ActiveField widget used by horizontal
 * bootstrap form (form classes = "form form-horizontal"
 * @package sjoorm\yii\widgets
 */
class HorizontalActiveField extends ActiveField {

    /** @inheritdoc */
    public $template = "{label}\n{input}";
    /** @inheritdoc */
    public $labelOptions = ['class' => 'control-label col-sm-4'];
    /** @inheritdoc */
    public $containerOptions = ['class' => 'col-sm-8'];

    /** @inheritdoc */
    public function render($content = null) {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $this->inputOptions);
            }
            if (!isset($this->parts['{label}'])) {
                $this->parts['{label}'] = Html::activeLabel($this->model, $this->attribute, $this->labelOptions);
            }
            if (!isset($this->parts['{error}'])) {
                $this->parts['{error}'] = Html::error($this->model, $this->attribute, $this->errorOptions);
            }
            if (!isset($this->parts['{hint}'])) {
                $this->parts['{hint}'] = '';
            }
            $containerTag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');
            $this->parts['{input}'] = Html::tag(
                $containerTag,
                "{$this->parts['{input}']}\n" . ArrayHelper::remove($this->parts, '{error}') . "\n" . ArrayHelper::remove($this->parts, '{hint}'),
                $this->containerOptions
            );
            $content = strtr($this->template, $this->parts);
        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    /** @inheritdoc */
    public function radioList($items, $options = ['class' => 'radio-list']) {
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeRadioList($this->model, $this->attribute, $items, $options);

        return $this;
    }

    /** @inheritdoc */
    public function checkboxList($items, $options = ['class' => 'checkbox-list']) {
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeCheckboxList($this->model, $this->attribute, $items, $options);

        return $this;
    }
}
