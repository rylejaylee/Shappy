<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME ?> - Home</title>
    <link rel="stylesheet" href="<?php echo asset('css/mdb.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <link rel="stylesheet" href="<?php echo asset('css/main.css') ?>">
    <style>
        .novel-card {
            width: 180px !important;
            height: 120px !important;
        }

        .novel-img {
            width: 180px !important;
            height: 200px !important;
        }

        .novel-img-2 {
            width: 100% !important;
            height: 160px !important;
        }

        .search-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-list {
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
            list-style-type: none;
            padding: 0;
            margin: 5px 35px 0 0;
            background-color: #fff;
            border: 1px solid #ccc;
            width: 350px;
            max-height: 500px;
            overflow-y: auto;
            z-index: 100;
        }

        .dropdown-list li {
            padding: 8px;
        }

        .dropdown-list li:hover {
            background-color: #f5f5f5;
        }

        @media only screen and (max-width: 490px) {
            .novel-card {
                width: 180px !important;
                height: 120px !important;
            }
        }

        @media only screen and (max-width: 1200px) {
            .novel-img-2 {
                width: 120px !important;
                height: 160px !important;

            }
        }
    </style>
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar brand -->
                <a class="navbar-brand mt-2 mt-lg-0" href="<?php echo url() ?>">
                    <h3>sHappy</h3>
                </a>
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url() ?>">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url("library") ?>">LIBRARY</a>
                    </li>
                    <li class="nav-item">

                        <div class="search-dropdown">
                            <form class="d-flex input-group w-auto">
                                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" id="search" />
                                <span class="input-group-text border-0" id="search-addon">
                                    <i class="fas fa-search"></i>
                                </span>
                            </form>
                            <ul class="dropdown-list card"></ul>
                        </div>
                    </li>
                </ul>

                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->

            <!-- Right elements -->
            <div class="d-flex align-items-center">
                <?php if (is_guest()) : ?>
                    <a href="<?php echo url('auth/login') ?>" class="btn btn-link px-3 me-2">
                        Login
                    </a>
                    <a href="<?php echo url('auth/register') ?>" class="btn btn-primary me-3">
                        Register Account
                    </a>
                <?php else : ?>
                    <!-- Avatar -->
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <small class="rounded-circle bg-primary p-1 text-white text-center" style="width: 30px; height: 30px;"><?php echo user_initials() ?></small>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                            <li>
                                <a class="dropdown-item text-primary" href="<?php echo url('novel/create') ?>"><i class="fas fa-pen"></i> Create Novel</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo url('settings') ?>"><i class="fas fa-cog"></i> Settings</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo url('auth/logout') ?>"><i class="fas fa-sign-out"></i> Logout</a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
            <!-- Right elements -->
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->

    <div class="container-fluid" style="height:80vh">