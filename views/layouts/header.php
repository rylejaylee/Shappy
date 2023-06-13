<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME ?> - Home</title>
</head>


<style>
    .d-flex {
        display: flex;
        flex-wrap: wrap;
    }

    .novel-card {
        margin: 10px 24px;
        width: 250px;
        height: auto;
        background-color: darkgoldenrod;
        text-align: center;
        text-decoration: none;
        padding: 8px;
        color: #222;
    }
</style>

<body>

    <h1><a href="/">Shappy!</a></h1>
    <?php if (is_authorized()) : ?>
        <h5><?php echo auth()->name; ?>---<?php echo auth()->email; ?></h5>

    <?php endif; ?>

    <?php if (is_guest()) : ?>
        <a href="/auth/login">Login</a>
        <a href="/auth/register">Register</a>
    <?php else : ?>
        <a href="/novel/create">Create Novel</a>
        <a href="/auth/logout">Logout</a>
    <?php endif; ?>