<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\BaseForm;

/**
 * Change Pass Form
 */
class ChangePassForm extends BaseForm
{
    public $staff_password;
    public $staff_password_new;
    public $staff_password_new_repeat;

    private $_user;
    const SCENARIO_CHANGEPASS = 'changePass';

    public function __construct($user = null)
    {
        $this->_user = $user;
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGEPASS] = ['staff_password_new', 'staff_password_new_repeat'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['staff_password', 'staff_password_new_repeat', 'staff_password_new'], 'required', 'message' => \Yii::t('app', 'required')],
            // password is validated by validatePassword()
            ['staff_password', 'validatePassword'],
            ['staff_password_new', 'validatePasswordNew'],
            [['staff_password_new'], 'string', 'length' => [8], 'tooShort' => \Yii::t('app', 'tring less than.', ['number' => 8])],
            [['staff_password_new'], 'string', 'max' => 32, 'tooLong' => \Yii::t('app', 'tring great than.', ['number' => 32])],
            // scenarios changePass in model StaffMst
            [['staff_password_new', 'staff_password_new_repeat'], 'required', 'on'=> self::SCENARIO_CHANGEPASS, 'message' => \Yii::t('app', 'required')],
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
                $this->addError($attribute, \Yii::t('app', 'password incorrect.'));
            }
        }
    }
    
    /**
     * Validates the new password.
     */
    public function validatePasswordNew($attribute, $params)
    {
        if ($this->staff_password_new !== $this->staff_password_new_repeat) {
            $this->addError($attribute, \Yii::t('app', 'pass not match.'));
        }
        
        if (!(preg_match('/\d+/', $this->staff_password_new) && preg_match('/[a-zA-Z]+/', $this->staff_password_new))) {
            $this->addError($attribute, \Yii::t('app', 'have to number and character.', ['attribute' => $this->attributeLabels()[$attribute]]));
        }
        
        if (!preg_match('/^[\\\!\"\#\$\%\&\'\(\)\*\+\,\-\.\/0123456789\:\;\<\=\>\?\@ABCDEFGHIJKLMNOPQRSTUVWXYZ\[\]\^\_\`abcdefghijklmnopqrstuvwxyz\{\|\}\~]+$/', $this->staff_password_new)) {
            $this->addError($attribute, \Yii::t('app', 'only aphabe.'));
        }
        
        if ($this->staff_password_new == $this->_user->staff_id) {
            $this->addError($attribute, \Yii::t('app', 'pass match staffId.'));
        }
        
        if ($this->_user->validatePassword($this->staff_password_new, $this->_user->staff_password)) {
            $this->addError($attribute, \Yii::t('app', 'pass same old pass.'));
        }
        
    }
    
    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function changePass()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            //update password and date update
            $user->setPassword($this->staff_password_new);
            $user->staff_last_upd_pass_date = date("Y-m-d H:i:s");
            $user->save();
            //set login cookie
            if ($this->scenario == self::SCENARIO_CHANGEPASS) {
                return true;
            } else {
                return Yii::$app->user->login($user, 3600 * 24 * 30);
            }
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
            $this->_user = \common\models\User::findByUsername($this->staff_mail);
        }

        return $this->_user;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_password' => '現在のパスワード',
            'staff_password_new' => '新しいパスワード',
            'staff_password_new_repeat' => '新しいパスワード（確認）',
        ];
    }
}
