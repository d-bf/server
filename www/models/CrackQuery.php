<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Crack]].
 * 
 * @see Crack
 */
class CrackQuery extends \yii\db\ActiveQuery
{

    /*
     * public function active()
     * {
     * $this->andWhere('[[status]]=1');
     * return $this;
     * }
     */
    
    /**
     * @inheritdoc
     * 
     * @return Crack[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * 
     * @return Crack|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}