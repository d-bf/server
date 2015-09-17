<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Cracker]].
 *
 * @see Cracker
 */
class CrackerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Cracker[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Cracker|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}