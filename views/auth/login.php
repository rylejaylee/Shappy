<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME ?> - Login</title>
</head>

<body>
    <h1>Login Page</h1>
    <?php if (session()->has('warning')) { ?>
        <?php echo session()->get('warning') ?>
    <?php } ?>

    <form action="/auth/login" method="POST">

        <label for="email">email</label>
        <input type="text" name="email" value="<?php echo old('email') ?? null ?>"><br>
        <label for="password">password</label>
        <input type="password" name="password"><br>
        <input type="submit" value="submit">
    </form>
</body>

</html>