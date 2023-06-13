<?php

namespace Shappy\Utils;

class Validator
{
    private $error_msg;

    public function password($password, $confirm_password)
    {
        if ($this->error_msg)  return;

        // Minimum length requirement
        if (strlen($password) < 6) {
            $this->error_msg =  "Password must be at least 6 characters long.";
        }

        // // Check for uppercase letters
        // else if (!preg_match("/[A-Z]/", $password)) {
        //     $this->error_msg =  "Password must contain at least one uppercase letter.";
        // }

        // // Check for lowercase letters
        // else if (!preg_match("/[a-z]/", $password)) {
        //     $this->error_msg =  "Password must contain at least one lowercase letter.";
        // }

        // // Check for digits
        // else if (!preg_match("/[0-9]/", $password)) {
        //     $this->error_msg =  "Password must contain at least one digit.";
        // }

        // // Check for special characters
        // else if (!preg_match("/[\W_]/", $password)) {
        //     $this->error_msg =  "Password must contain at least one special character.";
        // }

        // Check if confirm password matched
        else if ($password != $confirm_password) {
            $this->error_msg =  "Password does not match.";
        }
    }

    public function name($name)
    {
        if ($this->error_msg) return;

        // Check if the name is empty
        if (empty($name)) {
            $this->error_msg =  "Name cannot be empty.";
        }

        // Check if the name contains only letters and spaces
        else if (!preg_match("/^[a-zA-Z-'\s]+$/", $name)) {
            $this->error_msg =  "Invalid name format. Try again!";
        }

        // Check if the name has a minimum length of 2 characters
        else if (strlen($name) < 2) {
            $this->error_msg =  "Name must have at least 2 characters.";
        }

        // Check if the name has a maximum length of 50 characters
        else if (strlen($name) > 50) {
            $this->error_msg =  "Name cannot exceed 50 characters.";
        }

        // Name is valid
        return 1;
    }

    public function email($email)
    {
        if ($this->error_msg) return;

        // Check if the email is empty
        if (empty($email)) {
            $this->error_msg =  "Email address cannot be empty.";
        }

        // Validate email format
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error_msg =  "Invalid email address format.";
        }
    }

    public function email_exist($email)
    {
        $auth = new Auth;
        // Validate email existence
        if ($auth->email_exist($email)) {
            $this->error_msg =  "Email address already exists.";
        }
    }

    public function title($title)
    {

        // Check if the title is empty
        if (empty($title)) {
            $this->error_msg =  "Title cannot be empty.";
        }

        // Check the length of the title
        else if (strlen($title) > 255) {
            $this->error_msg =  "Title cannot exceed 255 characters.";
        }

        // Check if the title contains any invalid characters
        else if (!preg_match('/^[a-zA-Z0-9\s\'",.!?:-]+$/', $title)) {
            $this->error_msg =  "Title has invalid chacacters.";
        }
    }

    public function image($image_file)
    {
        if ($this->error_msg) return;
        $image_type = exif_imagetype($image_file["tmp_name"]);

        if (filesize($image_file["tmp_name"]) <= 0) {
            $this->error_msg =  "Uploaded file has no contents.";
        } else if (!$image_type) {
            $this->error_msg =  "File uploaded is not an image.";
        }
    }

    public function allowed_image($image_file, $allowed_extensions = ["jpg", "jpeg", "png", "gif"])
    {
        if ($this->error_msg) return;
        $image_extension = strtolower(pathinfo($image_file['name'], PATHINFO_EXTENSION));
        if (!in_array($image_extension, $allowed_extensions))
            $this->error_msg  = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    public function empty($text, $name = 'input')
    {
        if ($this->error_msg) return;
        $name =  ucwords($name);
        if (empty($text)) $this->error_msg =  "$name cannot be empty.";
    }

    public function max($text, $name, $max)
    {
        if ($this->error_msg) return;
        $name = ucwords($name);
        if (strlen($text) > $max) $this->error_msg =  "$name cannot exceed $max characters.";
    }

    public function has_error(): bool
    {
        return ($this->error_msg ? 1 : 0);
    }

    public function get_error()
    {
        return $this->error_msg;
    }
}
