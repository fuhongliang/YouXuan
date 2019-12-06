<?php

namespace app\commands;

use yii\console\Controller;
use SqlFormatter;

/**
 * Hejiang Toolkit
 */
class HjController extends Controller
{
    /**
     * Default command.
     */
    public function actionIndex()
    {
        var_dump(env('DB_MODE'));
    }

    /**
     * Pack sql querys as upgrade script format.
     */
    public function actionFormatSql()
    {
        $sql = stream_get_contents(fopen("php://stdin", "r"));
        $sql = SqlFormatter::compress($sql);
        $sqlList = SqlFormatter::splitQuery($sql);
        if(!$sqlList){
            throw new \Exception('No SQL given');
        }
        echo '{' . PHP_EOL;
        foreach($sqlList as $sql){
            $sql = trim($sql);
            echo "\thj_pdo_run(\"$sql\");" . PHP_EOL;
        }
        echo '}' . PHP_EOL;
    }
}
