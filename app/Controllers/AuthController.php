<?php

namespace App\Controllers;
use App\Models\User;
use Core\CookieManager;
use Core\Tools;
use Exception;

class AuthController
{

    private function checkFields(array $fields)
    {
        $errors = [];

        foreach ($fields as $key => $value)
            if (empty($value))
                $errors[] = ucfirst($key) . ' is required';

        return $errors;
    }
    private function encodePassword(string $pass): string
    {
        return md5($pass);
    }

    /**
     * @throws Exception
     */
    private function generateToken(): string
    {
        return bin2hex(random_bytes(TOKEN_LENGTH));
    }

    public function renderRegistration()
    {
        require_once ROOT . '/app/views/auth/RegistrationView.php';
    }

    public function registration()
    {
        $data = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'c_password' => $_POST['c_password'],
        ];

        $errors = $this->checkFields($data);

        if ($errors)
            foreach ($errors as $error)
                Tools::notify($error, 'red');
        else {
            $user = User::findOne([
                'email' => $data['email'],
            ]);

            if (! $user) {
                unset($data['c_password']);

                $data['password'] = $this->encodePassword($data['password']);

                User::create($data)->save();

                header('Location: /login');
            }

            Tools::notify("$user->email is taken...", 'red');
        }
    }

    public function renderLogin()
    {
        require_once ROOT . '/app/views/auth/LoginView.php';
    }

    /**
     * @throws Exception
     */
    public function login()
    {
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];

        $errors = $this->checkFields($data);

        if ($errors)
            foreach ($errors as $error)
                Tools::notify($error, 'red');
        else {
            $user = User::findOne(['email' => $data['email']]);

            if (! $user || $user->password !== $this->encodePassword($data['password']))
                Tools::notify("Email or password is invalid...", 'red');
            else {
                $user->token = $this->generateToken();

                $user->update();

                CookieManager::setUserCookie([
                    COOKIE_TOKEN_KEY => $user->token,
                    COOKIE_FIELD => json_encode([
                        'first_name'=>false,
                        'last_name' =>false,
                        'phone'     =>false,
                        'salary'    =>false,
                        ]),
                ]);

                header('Location: ' . HOME_URL);
            }
        }
    }
    public function logout(){
        CookieManager::deleteAllCookie();
        header('Location: /login');
    }
}
