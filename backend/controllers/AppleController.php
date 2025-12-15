<?php

namespace backend\controllers;

use common\contracts\Apple\AppleServiceInterface;
use Throwable;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

final class AppleController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly AppleServiceInterface $service,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        $apples = $this->service->list();

        return $this->render('index', [
            'apples' => $apples,
        ]);
    }

    public function actionGenerate(): Response
    {
        $count = (int)Yii::$app->request->post('count', 0);

        try {
            if ($count <= 0) {
                $count = random_int(1, 20);
            }

            $this->service->generate($count);
            Yii::$app->session->setFlash('success', "Сгенерировано яблок: {$count}");
        } catch (Throwable $exception) {
            Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionFall(int $id): Response
    {
        try {
            $this->service->fall($id);
            Yii::$app->session->setFlash('success', "Яблоко #{$id} упало на землю");
        } catch (Throwable $exception) {
            Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionEat(int $id): Response
    {
        $percent = (float)Yii::$app->request->post('percent', 0);

        try {
            $this->service->eat($id, $percent);
            Yii::$app->session->setFlash('success', "Яблоко #{$id}: съедено {$percent}%");
        } catch (Throwable $exception) {
            Yii::$app->session->setFlash('error', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'generate' => ['POST'],
                    'fall' => ['POST'],
                    'eat' => ['POST'],
                ],
            ],
        ];
    }
}
