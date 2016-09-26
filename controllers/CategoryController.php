<?php


namespace app\controllers;


use app\models\Product;
use app\models\Category;
use Yii;

class CategoryController extends AppController
{
	public function actionIndex()
	{
		$product = new Product();
		$hits = $product->getHitsProduct();

		return $this->render('index', compact('hits'));
	}

	public function actionView($id)
	{
		$product = new Product();
		$id = Yii::$app->request->get('id');
		$products = $product->getProductsByIdCategory($id);

		return $this->render('view', compact('products'));
	}
}