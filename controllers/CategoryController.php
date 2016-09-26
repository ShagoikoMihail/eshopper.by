<?php


namespace app\controllers;


use app\models\Product;

class CategoryController extends AppController
{
	public function actionIndex()
	{
		$product = new Product();
		$hits = $product->getHitsProduct();

		return $this->render('index', compact('hits'));
	}
}