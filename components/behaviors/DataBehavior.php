<?php
/**
 * Created by PhpStorm.
 * Author: Alexey Tishchenko
 * Email: tischenkoalexey1@gmail.com
 * oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * Date: 03.11.14
 */
namespace sjoorm\yii\components\behaviors;
/**
 * Trait DataBehavior implements actions specific for models
 * having JSON(MySQL TEXT) "data" column
 * @package sjoorm\yii\components\behaviors
 *
 * @property array|string $data
 */
trait DataBehavior {

    /** @var array */
    public $_data;

    /**
     * Overriding beforeValidate to set up json_encode(data) value
     * @return boolean
     */
    public function beforeValidate() {
        if(parent::beforeValidate()) {
            if(isset($this->_data) && is_array($this->_data)) {
                $this->data = json_encode($this->_data);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Overriding afterFind to set up json_decode(data) value
     */
    public function afterFind() {
        parent::afterFind();
        $this->_data = json_decode($this->data, true);
    }

    /**
     * Overriding afterConstruct to set up empty array (data) value
     */
    public function init() {
        parent::init();

        $this->_data = [];
    }

    /**
     * Sets value for given key in data JSON field
     * @param string|integer $key
     * @param mixed $value
     */
    public function setDataRecord($key, $value) {
        $this->_data[$key] = $value;
    }

    /**
     * Gets value through given key from data JSON field
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getDataRecord($key, $default = null) {
        return isset($this->_data[$key]) ? $this->_data[$key] : $default;
    }

    /**
     * Removes value through given key from data JSON array
     * @param string|integer $key
     */
    public function unsetDataRecord($key) {
        if(isset($this->_data[$key])) {
            unset($this->_data[$key]);
        }
    }
}
