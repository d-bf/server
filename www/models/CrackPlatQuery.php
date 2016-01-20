<?php
namespace app\models;

/**
 * This is the ActiveQuery class for [[CrackPlat]].
 *
 * @see CrackPlat
 */
class CrackPlatQuery extends \yii\db\ActiveQuery
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
     * @return CrackPlat[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     *
     * @return CrackPlat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}