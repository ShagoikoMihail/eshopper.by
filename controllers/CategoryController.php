<?php


namespace app\controllers;


use app\models\Category;
use app\models\Product;
use Yii;

class CategoryController extends AppController
{
	public function actionIndex()
	{
		$product = new Product();
		$hits = $product->getHitsProduct();
		$this->setMeta('E-SHOPPER');

		return $this->render('index', compact('hits'));
	}

	public function actionView()
	{
		$product = new Product();
		$category = new Category();
		$id = Yii::$app->request->get('id');
		$products = $product->getProductsByIdCategory($id);
		$cat = $category->getCategoryById($id);
		$this->setMeta('E-SHOPPER | ' . $cat->name, $cat->keywords, $cat->description);

		return $this->render('view', compact('products', 'cat'));
	}
}