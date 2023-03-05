<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "requests".
 *
 * @property int $id
 * @property string $child_name
 * @property string $birth_date
 * @property int $kindergarten_id
 * @property int $user_id
 * @property int $status
 * @property string|null $reason
 * @property string $created_at
 *
 * @property Kindergartens $kindergarten
 * @property Users $user
 */
class Requests extends \yii\db\ActiveRecord
{
    const NEW_REQ = 1;

    public $statusArr = [
        1 => 'нова',
        2 => 'прийнято',
        3 => 'відхилено'
    ];

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['child_name', 'birth_date', 'kindergarten_id', 'user_id', 'status'], 'required'],
            [['kindergarten_id', 'user_id', 'status'], 'integer'],
            [['reason'], 'string'],
            [['child_name'], 'string', 'max' => 255],
            ['birth_date', 'date', 'format' => 'php:Y-m-d'],
            ['birth_date', 'validateAge'],
//            ['kindergarten_id', 'validateChild'],
            [['kindergarten_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kindergartens::class, 'targetAttribute' => ['kindergarten_id' => 'kindergarten_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * Валидация возраста
     * @return void
     */
    public function validateAge($attribute, $params, $validator)
    {
        $maxAgeInYears = 5;
        $now = new \DateTime();
        $birthDate = \DateTime::createFromFormat('Y-m-d', $this->birth_date);
        $ageInterval = $now->diff($birthDate);
        $ageInYears = $ageInterval->y;

        if ($ageInYears > $maxAgeInYears) {
            $this->addError( $attribute,'Возраст ребенка не соответствует требованиям');
        }

    }

    public function validateChild($attribute, $params, $validator)
    {
        // параметры для запроса в бд
        // 'child_name', 'birth_date', 'kindergarten_id'б 'status' (1 или 3)
        //  $this->addError( $attribute,'Вы уже подали заявку в этот садик');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'child_name' => 'ПІБ дитини',
            'birth_date' => 'Дата народження',
            'kindergarten_id' => 'Kindergarten ID',
            'user_id' => 'ID користувача',
            'status' => 'Статус',
            'reason' => 'Причина',
            'created_at' => 'Дата, час подачі',
//            'kindergarten' => 'Назва садка'
        ];
    }

    /**
     * Gets query for [[Kindergarten]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKindergarten()
    {
        return $this->hasOne(Kindergartens::class, ['kindergarten_id' => 'kindergarten_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['user_id' => 'user_id']);
    }

    public function getReason()
    {
        return $this->hasOne(Requests::class, ['reason' => 'reason']);
    }

    public function getStatusName()
    {
        return $this->statusArr[$this->status];
    }

    public function getPreviousCount()
    {
        $count = Requests::find()
            ->where([
                'kindergarten_id' => $this->kindergarten_id,
                'status' => 1
            ])
            ->andWhere([
                '<', 'id', $this->id
            ])
            ->count();
        return $count;
    }
}
