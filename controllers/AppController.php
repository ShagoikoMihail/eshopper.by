<?php


namespace app\controllers;


use yii\web\Controller;

class AppController extends Controller
{
	protected function setMeta($title = NULL, $keywords = NULL, $description = NULL)
	{
		$this->view->title = $title;
		$this->view->registerMetaTag(['name' => 'keywords', 'content' => "$keywords"]);
		$this->view->registerMetaTag(['name' => 'description', 'content' => "$description"]);
	}
}