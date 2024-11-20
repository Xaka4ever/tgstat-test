<?php

namespace app\controllers;

use app\models\Link;
use app\models\LinkStat;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RedirectController handles the redirection based on the short token.
 */
class RedirectController extends Controller
{
    /**
     * Redirects the user to the full URL based on the provided short token.
     * @param string $token The short token.
     * @return yii\web\Response The redirection response.
     * @throws NotFoundHttpException If the short token is not found in the database.
     * @throws Exception
     */
    public function actionRedirect($token)
    {
        $link = Link::findOne(['short_token' => $token]);

        if ($link === null) {
            throw new NotFoundHttpException('The requested link does not exist.');
        }

        // Если используем Redis
        Yii::$app->redis->incr('link_stat:' . $link->id . ':' . date('Y-m-d'));

        // Если нагрузка небольшая и хватает прямых запросов в бд
        LinkStat::addStatToLink($link->id);

        return $this->redirect($link->url);
    }
}
