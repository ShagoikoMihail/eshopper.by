<?php


namespace app\controllers;

use app\models\Comments;
use app\models\Product;
use Yii;
use yii\data\Pagination;
use yii\web\HttpException;

class ProductController extends AppController
{
    public function actionView()
    {
        $product = new Product();
        $comments = new Comments();
        $id = Yii::$app->request->get('id');
        $prodComms = $comments->getCommentsByIdProduct($id);
        $oneProduct = $product->getOneProductById($id);
        if ($oneProduct === null) {
            throw new HttpException(404, 'Данного товара не существует.');
        }
        $recomProduct = $product->getHitsProduct();
        $this->setMeta('E-SHOPPER | ' . $oneProduct->name, $oneProduct->keywords, $oneProduct->description);

        return $this->render('view', compact('oneProduct', 'recomProduct', 'prodComms'));
    }


    public function actionSearch()
    {
        $product = new Product();
        $q = trim(Yii::$app->request->get('q'));
        $this->setMeta('E-SHOPPER | Поиск: ' . $q);
        if ($q) {
            $query = $product->search($q);
            $pages = new Pagination([
                'totalCount' => $query->count(),
                'pageSize' => 3,
                'forcePageParam' => false,
                'pageSizeParam' => false
            ]);
            $products = $query->offset($pages->offset)->limit($pages->limit)->all();

            return $this->render('search', compact('products', 'pages', 'q'));

        } else {
            throw new HttpException(400, 'Введите корректный запрос.');
        }
    }
}