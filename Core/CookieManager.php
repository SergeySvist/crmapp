<?php

namespace Core;

use App\Models\User;

class CookieManager
{
    public static User $authUser;
    public static function setUserCookie(array $cookie)
    {
        foreach ($cookie as $key => $val) {
            setcookie($key, $val, time() + COOKIE_LIFE_TIME, '/');
        }
    }

    public static function checkAuth(): bool
    {
        if (isset ($_COOKIE[COOKIE_TOKEN_KEY])) {
            $token = $_COOKIE[COOKIE_TOKEN_KEY];

            $user = User::findOne([
                'token' => $token,
            ]);

            if ($user) {
                self::$authUser = $user;
                return true;
            }
        }

        return false;
    }

    public static function deleteAllCookie(){
        foreach ($_COOKIE as $key=>$value){
            unset($_COOKIE[$key]);
            setcookie($key, "", time()-3600);
        }
    }


}
