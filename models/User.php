<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 *
 * @property Request[] $requests
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id'], 'integer'],
            ['role_id', 'default', 'value' => 1],
            [['username', 'password', 'email', 'first_name', 'last_name', 'middle_name', 'phone'],
                'required'],
            [['username', 'password', 'email', 'first_name', 'last_name', 'middle_name', 'phone'],
                'string', 'max' => 255],
            [['password'], 'string', 'min' => 6],
            [['username'], 'unique'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z]\w*$/i'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['role_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
            [['first_name', 'last_name', 'middle_name'], 'match', 'pattern' => '/^[а-яА-ЯёЁ ]*$/u'],
            //+7(XXX)-XXX-XX-XX
            [['phone'], 'match', 'pattern' => '/^\+?7\(\d{3}\)\-\d{3}-\d{2}-\d{2}$/']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Email',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'phone' => 'Телефон',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    public function getFullName()
    {
        return $this->last_name." ".$this->first_name." ".$this->middle_name;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        $this->password = md5($this->password);
        return parent::beforeSave($insert);
    }

    public function isAdmin()
    {
        return $this->role->code === 'admin';
    }
}
