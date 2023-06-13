<?php 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME ?> - Login</title>
</head>

<body>
    <h1>Register</h1>
    <?php if (session()->has('error')) { ?>
        <?php echo session()->get('error') ?>
    <?php } ?>
    <form action="/auth/register" method="POST">
        <label for="name">name</label>
        <input type="text" name="name" value="<?php echo old('name') ?>"><br>
        <label for="email">email</label>
        <input type="text" name="email" value="<?php echo old('email') ?>"><br>
        <label for="password">password</label>
        <input type="password" name="password"><br>
        <label for="confirm_password">confirm password</label>
        <input type="password" name="confirm_password"> <br>
        <input type="submit" value="submit">
    </form>
</body>

</html>