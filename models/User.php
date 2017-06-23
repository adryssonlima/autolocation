<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
	public $id;
	public $nome;
	public $email;
	public $password;
	public $tipo;
	public $authKey;
	public $accessToken;

/*    
	public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];
*/

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
    	//return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    	$user = Usuario::find()->where(['id'=>$id])->one();
		if($user){
			return new static($user);
		}
		return null;
	}

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
       /* foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
	   */
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($email)
    {
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }*/
		$user = Usuario::find()->where(['email'=>$email])->one();
		if($user){
			return new static($user);
		}

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        //return $this->authKey;
    	return null;
	}

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        //return $this->authKey === $authKey;
    	return null;
	}

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
		//Depois criptografar as senhas
		//return $this->password === md5($password);
    }
}
