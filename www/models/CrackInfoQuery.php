<?php
namespace app\models;

/**
 * This is the ActiveQuery class for [[CrackInfo]].
 *
 * @see CrackInfo
 */
class CrackInfoQuery extends \yii\db\ActiveQuery
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
     * @return CrackInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     *
     * @return CrackInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}