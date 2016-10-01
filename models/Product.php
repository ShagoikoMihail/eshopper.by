<?php


namespace app\models;


use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'product';
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getHitsProduct()
    {
        $products = static::find()->where(['hit' => '1'])->limit(6)->all();

        return $products;
    }

    public function getProductsByIdCategory($id)
    {
        $products = static::find()->where(['category_id' => $id]);

        return $products;
    }

    public function getOneProductById($id)
    {
        return static::findOne($id);
    }

    public function search($q)
    {
        return static::find()->where(['like', 'name', $q]);
    }
}