<?php
/**
 * Created by PhpStorm.
 * @author: Alexey Tishchenko
 * @email: tischenkoalexey1@gmail.com
 * @oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * @date: 20.05.15
 */
namespace sjoorm\yii\components\interfaces;
/**
 * Interface PrintableRecordInterface
 * implements records can be printed with specified attributes
 * @package sjoorm\yii\components\interfaces
 */
interface PrintableRecordInterface {

    /**
     * Gets list of attributes for printable representation of a record
     * @param boolean $html if HTML code is accepted
     * @return array
     */
    public function getAttributesToPrint($html = true);
}
