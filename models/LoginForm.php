<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $staff_id;
    public $staff_password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['staff_id', 'staff_password'], 'required', 'message' => \Yii::t('app', 'required')],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['staff_password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->staff_password)) {
                $this->addError($attribute, \Yii::t('app', 'Incorrect username or password.'));
                $this->countLoginFail();
            } else {
                if ($user->staff_status == $user::STATUS_LOCK) {
                    $this->addError($attribute, \Yii::t('app', 'User locked.'));
                }
            }
        }
    }
    
    /**
     * Count when login fail
     */
    public function countLoginFail()
    {
        //count login incorect pass
        $user = $this->getUser();
        if (!empty($user)) {
            $user->staff_count_login_fail ++;

            if ($user->staff_count_login_fail === $user::COUNT_LOGIN_FAIL) {
                $user->staff_status = $user::STATUS_LOCK;
            }

            $user->save();
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user->isPasswordExpired()) {
                $session = Yii::$app->session;
                $session->set('user', $user);
                return 'password_expired';
            }
            //update count error login to 0
            $user->staff_count_login_fail = 0;
            $user->save();
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->staff_id);
        }

        return $this->_user;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => 'ユーザID',
            'staff_password' => 'パスワード',
        ];
    }
}
