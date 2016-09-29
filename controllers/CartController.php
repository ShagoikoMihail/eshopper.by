<?php


namespace app\controllers;

use app\models\Cart;
use app\models\Order;
use app\models\Product;
use Yii;


class CartController extends AppController
{
    public function actionAdd()
    {
        $product = new Product();
        $cart = new Cart();
        $id = Yii::$app->request->get('id');
        $qty = (int)Yii::$app->request->get('qty');
        $qty = !$qty ? 1 : $qty;
        $oneProduct = $product->getOneProductById($id);
        if (empty($oneProduct)) {
            return false;
        }
        $session = Yii::$app->session;
        $session->open();
        $cart->addToCart($oneProduct, $qty);
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('cart-modal', compact('session'));
    }

    public function actionClear()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');

        return $this->renderAjax('cart-modal', compact('session'));
    }

    public function actionDelItem()
    {
        $cart = new Cart();
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        $session->open();
        $cart->recalc($id);

        return $this->renderAjax('cart-modal', compact('session'));
    }

    public function actionShow()
    {
        $session = Yii::$app->session;
        $session->open();

        return $this->renderAjax('cart-modal', compact('session'));
    }

    public function actionView()
    {
        $order = new Order();
        $session = Yii::$app->session;
        $session->open();
        $this->setMeta('Корзина');
        if ($order->load(Yii::$app->request->post())) {
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            if ($order->save()) {
                $order->saveOrderItems($session['cart'], $order->id);
                Yii::$app->mailer->compose('order', compact('session'))
                    ->setFrom(['mixaendminsk@mail.ru' => 'E-SHOPPER'])
                    ->setTo($order->email)
                    ->setSubject('Заказ')
                    ->send();
                $session->remove('cart');
                $session->remove('cart.qty');
                $session->remove('cart.sum');
                Yii::$app->session->setFlash('success', 'Ваш заказ принят');

                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка оформления заказа');
            }
        }

        return $this->render('view', compact('session', 'order'));
    }
}