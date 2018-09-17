<?php
namespace common\models;

use mohorev\file\UploadImageBehavior;
use phpDocumentor\Reflection\Types\Self_;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\Linkable;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $avatar
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @mixin UploadImageBehavior
 */
class User extends ActiveRecord implements IdentityInterface
{
    private $_password;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const STATUS_TEXT = [
        self::STATUS_ACTIVE => 'активен',
        self::STATUS_DELETED => 'удален'
    ];

    const SCENARIO_ADMIN_CREATE = 'user_create';
    const SCENARIO_ADMIN_UPDATE = 'user_update';

    const AVATAR_ICON = 'icon';
    const AVATAR_PREVIEW = 'preview';
    const AVATAR_COMMENTS = 'comments';
    const AVATAR_CONFIG = [
        self::AVATAR_ICON => ['width' => 15, 'quality' => 90],
        self::AVATAR_PREVIEW => ['width' => 200, 'height' => 200],
        self::AVATAR_COMMENTS => ['width' => 30]
    ];

    const AVATAR_IMG_DIR = '/upload/avatar/';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $host = Yii::$app->params['frontScheme'] . Yii::$app->params['frontDomain'];

        return [
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_ADMIN_UPDATE],
                //'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
                'path' => '@frontend/web/upload/avatar/{id}',
                'url' => $host . self::AVATAR_IMG_DIR . '{id}',
                'thumbs' => [
                    self::AVATAR_ICON => self::AVATAR_CONFIG[self::AVATAR_ICON],
                    self::AVATAR_PREVIEW => self::AVATAR_CONFIG[self::AVATAR_PREVIEW],
                    self::AVATAR_COMMENTS => self::AVATAR_CONFIG[self::AVATAR_COMMENTS]
                ],
            ],
            TimestampBehavior::className(),
        ];
    }

    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)){
            return false;
        }

        if($this->isNewRecord){
            $this->generateAuthKey();
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['email', 'email'],
            [['username', 'email'], 'unique'],
            [['password', 'username', 'email'], 'required', 'on' => self::SCENARIO_ADMIN_CREATE],
            [['username', 'email'], 'required', 'on' => self::SCENARIO_ADMIN_UPDATE],
            [
                'avatar', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_ADMIN_UPDATE],
                'minSize' => '100',
                'maxSize' => '10000000']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'avatar' => 'Аватар',
            'username' => 'Имя',
            'login' => 'Логин',
            'status' => 'Статус',
            'password' => 'Пароль',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     *
     * @param string $password
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(Project::class, ['user_id => id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::class, ['id => project_id'])->via('projectUsers');
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        if(!$password){
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
        $this->_password = $password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    /**
     * @return null|string
     */
    public function getAvatar()
    {
        return $this->getThumbUploadUrl('avatar', self::AVATAR_COMMENTS);
    }


}
