<?php

namespace app\models;

/**
 * @param int $id
 * @param string $username
 * @param string $password
 * @param string $authKey
 * @param string $accessToken
 */
class UserIdentity extends Users implements \yii\web\IdentityInterface
{

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['accessToken'=>$token]);
    }

    /**
     * Finds user by username
     * @return static|null
     */
    public static function findByUsername(string $username)
    {
        return self::findOne(['username'=>$username]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword( string $password): bool
    {
        return $this->password === md5($password);
    }
}
