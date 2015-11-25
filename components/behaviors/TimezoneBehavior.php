<?php
/**
 * Created by PhpStorm.
 * @author: Alexey Tishchenko
 * @email: tischenkoalexey1@gmail.com
 * @oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * @date: 20.07.15
 */
namespace sjoorm\yii\components\behaviors;
/**
 * Trait TimezoneBehavior performs model's timezone-oriented datetime calculations
 * @package sjoorm\yii\components\behaviors
 * @property integer $timezone
 */
trait TimezoneBehavior {

    /** @var \DateTimeZone */
    private $_timeZoneUser;
    /** @var \DateTimeZone */
    private $_timeZoneUTC;

    /**
     * Initializes time zones
     */
    private function dateTimeInit() {
        if(empty($this->_timeZoneUser)) {
            $this->_timeZoneUser = new \DateTimeZone($this->timezone);
        }
        if(empty($this->_timeZoneUTC)) {
            $this->_timeZoneUTC = new \DateTimeZone('UTC');
        }
    }

    /**
     * Formats DateTime object via Yii::$app->formatter
     * @param \DateTime $dateTime
     * @return string
     */
    private function format($dateTime) {
        $oldTimeZone = \Yii::$app->formatter->timeZone;
        \Yii::$app->formatter->timeZone = $dateTime->getTimezone()->getName();
        $result = \Yii::$app->formatter->asDatetime($dateTime);
        \Yii::$app->formatter->timeZone = $oldTimeZone;

        return $result;
    }

    /**
     * @param integer|string|\DateTime $source
     * @param boolean|true $format
     * @return \DateTime|string
     */
    public function dateTimeUserToUtc($source, $format = true) {
        $this->dateTimeInit();

        if($source instanceof \DateTime) {
            $dateTime = $source;
            $dateTime->setTimezone($this->_timeZoneUser);
        } else {
            $dateTime = new \DateTime($source, $this->_timeZoneUser);
        }
        $dateTime->setTimezone($this->_timeZoneUTC);

        if($format) {
            $result = $this->format($dateTime);
        } else {
            $result = $dateTime;
        }

        return $result;
    }

    /**
     * @param integer|string|\DateTime $source
     * @param boolean|true $format
     * @return \DateTime|string
     */
    public function dateTimeUtcToUser($source, $format = true) {
        $this->dateTimeInit();

        if($source instanceof \DateTime) {
            $dateTime = $source;
            $dateTime->setTimezone($this->_timeZoneUTC);
        } else {
            $dateTime = new \DateTime($source, $this->_timeZoneUTC);
        }
        $dateTime->setTimezone($this->_timeZoneUser);

        if($format) {
            $result = $this->format($dateTime);
        } else {
            $result = $dateTime;
        }

        return $result;
    }
}
