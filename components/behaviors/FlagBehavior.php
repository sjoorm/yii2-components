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
 * Trait FlagBehavior implements actions specific for models
 * having integer "flags" column and different FLAGS constants
 * @package sjoorm\yii\components\behaviors
 *
 * @property integer $flags
 * @property array $flagsList all available flags as [flag => name] array
 * @property array $flagsAssigned all assigned flags as [flag => name] array
 * @property array $flagsCheckboxList all assigned flags as [flag => name] array
 * for ActiveForm CheckboxList element
 */
trait FlagBehavior {

    use ConstBehavior;

    /**
     * Assigns flag to user model
     * @param integer $flag User::FLAG_*
     */
    public function assignFlag($flag) {
        $this->flags |= (int)$flag;
    }

    /**
     * Checks if model has specified flag assigned
     * @param integer $flag
     * @return boolean
     */
    public function hasFlag($flag) {
        return (bool)((int)$this->flags & (int)$flag);
    }

    /**
     * Revokes flag from user model
     * @param integer $flag
     */
    public function revokeFlag($flag) {
        if($this->hasFlag($flag)) {
            $this->flags ^= (int)$flag;
        }
    }

    /**
     * Creates list of all available FLAG constants as [flag => name]
     * @return array
     */
    public function getFlagsList() {
        return $this->getConstants('FLAG');
    }

    /**
     * Lists all assigned flags that model has
     * @return array of flags as value => name
     */
    public function getFlagsAssigned() {
        $result = [];

        foreach($this->flagsList as $value => $name) {
            if($this->hasFlag($value)) {
                $result[$value] = $name;
            }
        }

        return $result;
    }

    /**
     * Gets list of assigned flags for checkbox list population
     * @return array
     */
    public function getFlagsCheckboxList() {
        return array_keys($this->flagsAssigned);
    }

    /**
     * Assigns all specified flag values
     * @param array $flags flag values array
     */
    public function setFlagsCheckboxList($flags) {
        $this->flags = 0;
        if(is_array($flags)) {
            foreach ($flags as $flag) {
                $this->assignFlag($flag);
            }
        }
    }
}
