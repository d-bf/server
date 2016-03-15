<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Download]].
 *
 * @see Download
 */
class DownloadQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Download[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Download|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}