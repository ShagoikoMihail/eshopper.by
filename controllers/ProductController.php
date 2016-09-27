<?php


namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;
use yii\web\HttpException;

class ProductController extends AppController
{
	public function actionView()
	{
		$product = new Product();
		$id = Yii::$app->request->get('id');
		$oneProduct = $product->getOneProductById($id);
		if ($oneProduct === NULL) {
			throw new HttpException(404, 'Данного товара не существует.');
		}
		$recomProduct = $product->getHitsProduct();
		$this->setMeta('E-SHOPPER | ' . $oneProduct->name, $oneProduct->keywords, $oneProduct->description);

		return $this->render('view', compact('oneProduct', 'recomProduct'));
	}
}