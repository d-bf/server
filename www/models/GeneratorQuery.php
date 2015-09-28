<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Generator]].
 * 
 * @see Generator
 */
class GeneratorQuery extends \yii\db\ActiveQuery
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
     * @return Generator[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * 
     * @return Generator|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}