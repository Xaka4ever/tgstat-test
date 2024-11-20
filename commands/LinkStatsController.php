<?php

namespace app\commands;

use app\models\LinkStat;
use Yii;
use yii\console\Controller;
use yii\db\Exception;

/*
 * Пример cron
 * * * * * /path/to/php /path/to/yii link-stats/process
 *
 */

class LinkStatsController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionProcess()
    {
        $redis = Yii::$app->redis;
        $keys = $redis->keys('link_stat:*');

        foreach ($keys as $key) {
            [$prefix, $linkId, $date] = explode(':', $key);
            $count = $redis->get($key);

            LinkStat::addStatToLink($linkId, $count, $date);

            $redis->del($key);
        }
    }
}
