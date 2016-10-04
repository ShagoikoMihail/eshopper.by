<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $body
 * @property string $dt
 * @property integer $product_id
 */
class Comments extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dt'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'body'], 'required'],
            [['body'], 'string'],
            [['dt'], 'safe'],
            [['product_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['email'], 'string', 'max' => 255],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'E-mail',
            'body' => 'Комментарий',
            'dt' => 'Dt',
            'product_id' => 'Product ID',
        ];
    }

    public function getCommentsByIdProduct($id)
    {
        return static::find()->where(['product_id' => $id])->orderBy(['dt' => SORT_DESC])->all();
    }
}
