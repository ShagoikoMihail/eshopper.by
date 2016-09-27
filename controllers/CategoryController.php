<?php


namespace app\controllers;


use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;
use yii\web\HttpException;

class CategoryController extends AppController
{
	public function actionIndex()
	{
		$product = new Product();
		$hits = $product->getHitsProduct();
		$this->setMeta('E-SHOPPER');

		return $this->render('index', compact('hits'));
	}

	public function actionView($id)
	{
		$product = new Product();
		$category = new Category();
		$id = Yii::$app->request->get('id');
		$cat = $category->getCategoryById($id);
		if ($cat === NULL) {
			throw new HttpException(404, 'Данной категории не существует.');
		}
		$query = $product->getProductsByIdCategory($id);
		$pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => FALSE, 'pageSizeParam' => FALSE]);

		$this->setMeta('E-SHOPPER | ' . $cat->name, $cat->keywords, $cat->description);
		$products = $query->offset($pages->offset)->limit($pages->limit)->all();


		return $this->render('view', compact('products', 'cat', 'pages'));
	}
}