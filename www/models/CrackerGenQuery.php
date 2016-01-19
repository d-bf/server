<?php
namespace app\models;

/**
 * This is the ActiveQuery class for [[CrackerGen]].
 *
 * @see CrackerGen
 */
class CrackerGenQuery extends \yii\db\ActiveQuery
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
     * @return CrackerGen[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     *
     * @return CrackerGen|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}