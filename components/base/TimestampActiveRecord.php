<?php
/**
 * Created by PhpStorm.
 * Author: Alexey Tishchenko
 * Email: tischenkoalexey1@gmail.com
 * oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * Date: 03.11.14
 */
namespace common\components\base;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
/**
 * Class TimestampActiveRecord implements TimestampBehavior usage
 * and statistics method for MySQL table model
 * @package common\components\base
 *
 * @method void touch(string $attribute) TimestampBehavior->touch()
 */
class TimestampActiveRecord extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Gets statistics of table INSERTs by days as [dt => amount]
     * @param \DateTime $dateFrom
     * @param string $threshold
     * @param string $column
     * @param string $operator COUNT or SUM
     * @param string $condition optional WHERE condition
     * @param integer $cache cache duration
     * @return array
     */
    public static function getStatistics($dateFrom, $threshold = 'month', $column = 'id', $operator = 'COUNT', $condition = '', $cache = null) {
        $cache = $cache ?: \Yii::$app->params['cacheDuration'];
        $timestampBehavior = (new static())->getBehavior('timestamp');
        /** @var TimestampBehavior $timestampBehavior */
        $createdAtAttribute = $timestampBehavior->createdAtAttribute;
        return \Yii::$app->db->cache(function($db) use($dateFrom, $threshold, $column, $operator, $condition, $createdAtAttribute) {
            /** @var \yii\db\Connection $db */
            $dateTo = new \DateTime();
            $dateInterval = new \DateInterval($threshold === 'year' ? 'P1M' : 'P1D');
            $dateRange = new \DatePeriod($dateFrom, $dateInterval, $dateTo);

            $range = [];
            foreach($dateRange as $date) {
                /* @var \DateTime $date */
                $range[$date->format($threshold === 'year' ? 'Y-n' : 'Y-m-d')] = 0;
            }

            $date = $dateFrom->format('Y-m-d 00:00:00');
            $table = static::tableName();
            if(!empty($condition)) {
                $condition = "AND $condition";
            }
            $statistics = array_column($db->createCommand($threshold === 'year' ? "
                SELECT CONCAT(YEAR($createdAtAttribute), '-', MONTH($createdAtAttribute)) AS dt,
                $operator($column) AS amount
                FROM $table
                WHERE $createdAtAttribute > '$date' $condition
                GROUP BY dt
            " : "
                SELECT DATE($createdAtAttribute) AS dt, $operator($column) AS amount
                FROM $table
                WHERE $createdAtAttribute > '$date' $condition
                GROUP BY dt
            ")->queryAll(), 'amount', 'dt');

            return array_merge($range, $statistics);
        }, $cache);
    }
}
