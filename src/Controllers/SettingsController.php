<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\User;
use Shappy\Utils\Auth;
use Shappy\Utils\Validator;

class SettingsController extends Controller
{

    public function index()
    {
        $user = auth();
        return $this->view("settings/index", compact('user'));
    }

    public function update_user(Request $request)
    {
        $userObject = new User;
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');
        $old_password = $request->input('old_password');

        $validator = new Validator;

        // validate inputs
        $validator->name($name);
        $validator->email($email);
        if ($email != auth()->email)
            $validator->email_exist($email);
        if ($password) {
            $validator->password($password, $confirm_password);
        }


        $user = $userObject->get_current_user();

        if (!password_verify($old_password, $user->password))
            $validator->set_error("Wrong password.");

        if ($validator->has_error()) {
            $this->flash('error', $validator->get_error());
            return $this->redirect('/settings');
        }

      
        if ($userObject->update($name, $email, $password)) {
            $this->flash('success', 'You have updated your account.');
            auth()->name = $name;
            auth()->email = $email;
        }
        return $this->redirect('/settings');
    }
}
