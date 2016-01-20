<?php
namespace app\models;

/**
 * This is the ActiveQuery class for [[PlatAlgoCracker]].
 *
 * @see PlatAlgoCracker
 */
class PlatAlgoCrackerQuery extends \yii\db\ActiveQuery
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
     * @return PlatAlgoCracker[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     *
     * @return PlatAlgoCracker|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}