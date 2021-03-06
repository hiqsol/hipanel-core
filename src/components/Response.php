<?php
/**
 * HiPanel core package.
 *
 * @link      https://hipanel.com/
 * @package   hipanel-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\components;

use Yii;

class Response extends \yii\web\Response
{
    public function sendContent()
    {
        if ($this->stream === null) {
            $this->content = Yii::$app->getI18n()->removeLegacyLangTags($this->content);
        }
        parent::sendContent();
    }
}
