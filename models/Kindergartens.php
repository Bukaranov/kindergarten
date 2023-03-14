<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "kindergartens".
 *
 * @property int $kindergarten_id
 * @property string $name
 * @property int $capacity
 *
 * @property Requests[] $requests
 */
class Kindergartens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kindergartens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['capacity'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kindergarten_id' => 'ID дитячого садка',
            'name' => 'Назва садка',
            'capacity' => 'Місткість',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Requests::class, ['kindergarten_id' => 'kindergarten_id']);
    }

    /**
     * Кол-во принятых заявок
     * @return bool|int|string|null
     */
    public function getRequestsCount()
    {
        // $query = Requests::find()->where(['kindergarten_id' => $this->kindergarten_id]);
        // Одно и тоже
        $query = $this->getRequests();

        return $query->andWhere([
                'status' => 2
            ])
            ->count();
    }

    //Связь с таблицей (Users)
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])
            ->viaTable('requests', ['kindergarten_id' => 'id']);
    }

    public function isNoPlace()
    {
        return $this->requestsCount >= $this->capacity;
    }

    public static function getList()
    {
        $models = self::find()->all();
        foreach ($models as $model) {
            if (!$model->isNoPlace()) {
                $result[$model->kindergarten_id] = $model->name;
            }
        }

        return $result;
    }
}
