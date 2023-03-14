<?php

namespace app\models;

use DateTime;
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
            ['child_name', 'unique',
                'targetAttribute' => ['child_name', 'birth_date', 'kindergarten_id'],
                'filter' => function ($query) {
                    return $query->andWhere(['!=', 'status', 3]);
                },
                'message' => 'Заява на цю дитину вже існує'
            ],
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
//        var_dump($ageInYears);die;
        if ($ageInYears > $maxAgeInYears) {
            $this->addError( $attribute,'Возраст ребенка не соответствует требованиям');
        }

    }

    public function validateAge2($attribute, $params, $validator)
    {
        $birthday = new DateTime($this->birth_date);
        $now = new \DateTime();
        $diff = $birthday->diff($now);
        var_dump($diff->y);die;
        if ($diff->y > 5) {
            $this->addError( $attribute,'Возраст ребенка не соответствует требованиям');
        }

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
            'kindergarten_id' => 'Дитячий садок',
            'user_id' => 'ID користувача',
            'status' => 'Статус',
            'reason' => 'Причина',
            'created_at' => 'Дата, час подачі',
            'kindergarten' => 'Назва садка'
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

    /**
     *
     * @return string
     */
    public function getStatusName()
    {
        return $this->statusArr[$this->status];
    }

    /**
     *
     * @return int
     */
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
