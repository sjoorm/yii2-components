<?php
/**
 * Created by PhpStorm.
 * @author: Alexey Tishchenko
 * @email: tischenkoalexey1@gmail.com
 * @oDesk: https://www.odesk.com/users/%7E01ad7ed1a6ade4e02e
 * @date: 26.02.15
 */
namespace common\components\behaviors;
/**
 * Trait HashIdBehavior implements ID-hashing actions for model's "id" column
 * @package common\components\behaviors
 * @property integer $id
 * @property integer $hashId
 * @method static \yii\db\ActiveRecord findOne(mixed $id)
 */
trait HashIdBehavior {

    private static $SALT_XOR_HASH_ID = 0b1110110101110111;
    private static $SALT_MUL_HASH_ID = 0b0111011101011101;

    /**
     * Retrieves hashed ID of the current record
     * @return integer
     */
    public function getHashId() {
        return (($this->id * self::$SALT_MUL_HASH_ID) ^ self::$SALT_XOR_HASH_ID);
    }

    /**
     * Finds record with specified hashed ID
     * @param integer $id
     * @return null|static
     */
    public static function findByHashId($id) {
        return static::findOne(((integer)$id ^ self::$SALT_XOR_HASH_ID) / self::$SALT_MUL_HASH_ID);
    }
}
