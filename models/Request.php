<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $status_id
 * @property string $auto_number
 * @property string|null $text
 * @property string|null $created_at
 *
 * @property Status $status
 * @property User $user
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status_id'], 'integer'],
            ['user_id', 'default', 'value' => \Yii::$app->user->identity->getId()],
            [['auto_number'], 'required'],
            [['text'], 'string'],
            [['created_at'], 'safe'],
            [['auto_number'], 'string', 'max' => 255],
            [['auto_number'], 'unique'],
            [['status_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status_id' => 'Status ID',
            'auto_number' => 'Номер автомобиля',
            'text' => 'Описание нарушения',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
