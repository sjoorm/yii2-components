<?php
/**
 * Created by PhpStorm.
 * @author: Alexey Tishchenko
 * @email: tischenkoalexey1@gmail.com
 * @oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * @date: 18.07.15
 */
namespace sjoorm\yii\components\behaviors;
/**
 * Trait ConstBehavior gives possibility to get all constants of one subgroup
 * (with the same prefix)
 * @package sjoorm\yii\components\behaviors
 */
trait ConstBehavior {

    /**
     * Gets all constants belongs to specified subgroup
     * @param string $prefix
     * @return array
     */
    public function getConstants($prefix) {
        $result = [];

        $class = new \ReflectionClass($this);
        foreach($class->getConstants() as $name => $value) {
            $constName = explode('_', $name);
            if(array_shift($constName) === $prefix) {
                $constName = implode('', array_map(function($name) {
                    return ucfirst(strtolower($name));
                }, $constName));
                $result[$value] = $constName;
            }
        }

        return $result;
    }
}
