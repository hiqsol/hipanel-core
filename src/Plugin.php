<?php

namespace hipanel;

use Yii;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'translations' => [
            'synt' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@hipanel/common/messages',
                'fileMap' => [
                    'synt' => 'synt.php'
                ]
            ],
            'app' => [
                'class'          => 'yii\i18n\PhpMessageSource',
                'basePath'       => '@hipanel/common/messages',
                'sourceLanguage' => 'en-US',
                'fileMap'        => [
                    'app'       => 'app.php',
                    'app/error' => 'error.php',
                ],
            ],
        ],
    ];

    public function init()
    {
        parent::init();
        $version = Yii::$app->extensions['hiqdev/hipanel-core']['version'];
        if ($version == '9999999-dev') {
            $v = file_get_contents(Yii::getAlias('@hipanel/../.git/refs/heads/master'));
            $version = $v ? substr($v, 0, 7) : $version;
        }
        Yii::$app->params['poweredByVersion'] = $version;
    }
}
