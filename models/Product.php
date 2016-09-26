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
		return $this->hasOne(Category::className(), ['id', 'category_id']);
	}

	public function getHitsProduct()
	{
		$products = self::find()->where(['hit' => '1'])->limit(6)->all();

		return $products;
	}
}