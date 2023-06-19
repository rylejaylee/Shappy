<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Utils\Auth;
use Shappy\Utils\Guard;
use Shappy\Utils\Validator;

class AuthController extends Controller
{
    // private $requests;
    private $validator;
    private $auth;

    public function __construct()
    {
        // $this->requests = new Requests;
        $this->validator = new Validator;
        $this->auth = new Auth;
    }

    public function login_view()
    {
        Guard::guest();
        return $this->view('auth/login');
    }

    public function register_view()
    {
        Guard::guest();
        return $this->view('auth/register');
    }


    public function login(Request $request)
    {
        Guard::guest();

        $email = $request->input('email');
        $password = $request->input('password');

        if (empty($email) || empty($password)) {
            $this->flash('warning', 'Please provide your email and password!');
            return $this->back();
        }

        if ($this->auth->login($email, $password)) {
            return $this->redirect('/');
        }

        return $this->back();
    }

    public function register(Request $request)
    {
        Guard::guest();

        // catch request inputs
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        // validate inputs
        $this->validator->name($name);
        $this->validator->email($email);
        $this->validator->email_exist($email);
        $this->validator->password($password, $confirm_password);

        if ($this->validator->has_error()) {
            $this->flash('error', $this->validator->get_error());
            return $this->back();
        } else {

            $result = $this->auth->register($name, $email, $password);

            if ($result) {
                $this->flash('success', 'Congrats! You have created an account.');

                if ($this->auth->login($email, $password))
                    return $this->redirect('/');
            } else {
                $this->flash('error', 'Sorry! Something went wrong. You have failed to create an account.');
            }
        }
    }

    public function logout()
    {
        $this->auth->logout();
        return $this->redirect('/');
    }
}
