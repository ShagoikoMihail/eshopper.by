<?php


namespace app\controllers;

use app\models\Cart;
use app\models\Product;
use Yii;


class CartController extends AppController
{
	public function actionAdd()
	{
		$product = new Product();
		$id = Yii::$app->request->get('id');
		$qty = (int)Yii::$app->request->get('qty');
		$qty = !$qty ? 1 : $qty;
		$oneProduct = $product->getOneProductById($id);
		if (empty($oneProduct)) return FALSE;
		$session = Yii::$app->session;
		$session->open();
		$cart = new Cart();
		$cart->addToCart($oneProduct, $qty);
		if (!Yii::$app->request->isAjax) {
			return $this->redirect(Yii::$app->request->referrer);
		}
		$this->layout = FALSE;

		return $this->render('cart-modal', compact('session'));
	}

	public function actionClear()
	{
		$session = Yii::$app->session;
		$session->open();
		$session->remove('cart');
		$session->remove('cart.qty');
		$session->remove('cart.sum');
		$this->layout = FALSE;

		return $this->render('cart-modal', compact('session'));
	}

	public function actionDelItem()
	{
		$id = Yii::$app->request->get('id');
		$session = Yii::$app->session;
		$session->open();
		$cart = new Cart();
		$cart->recalc($id);
		$this->layout = FALSE;

		return $this->render('cart-modal', compact('session'));
	}

	public function actionShow()
	{
		$session = Yii::$app->session;
		$session->open();
		$this->layout = FALSE;

		return $this->render('cart-modal', compact('session'));
	}
}