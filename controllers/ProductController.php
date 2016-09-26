<?php


namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController
{
	public function actionView($id)
	{
		$product = new Product();
		$id = Yii::$app->request->get('id');
		$oneProduct = $product->getOneProductById($id);
		$recomProduct = $product->getHitsProduct();
		$this->setMeta('E-SHOPPER | ' . $oneProduct->name, $oneProduct->keywords, $oneProduct->description);

		return $this->render('view', compact('oneProduct', 'recomProduct'));
	}
}