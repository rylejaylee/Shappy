<?php include_once 'views/layouts/header.php' ?>

<div class="row d-flex justify-content-center align-items-center" style="height:100%">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">
                    <span class="text-primary">sHappy</span> - Register
                    <hr>
                </h1>

                <?php if (session()->has('error')) { ?>
                    <p class="text-danger text-center">
                        <?php echo session()->get('error') ?>
                    </p>
                <?php } ?>

                <form action="<?php echo url('auth/register') ?>" method="POST">
                    <div class="form-outline mt-3">
                        <input type="text" name="name" class="form-control form-control-lg" value="<?php echo old('name') ?? null ?>" />
                        <label class="form-label">Name</label>
                    </div>
                    <div class="form-outline mt-3">
                        <input type="text" name="email" class="form-control form-control-lg" value="<?php echo old('email') ?? null ?>" />
                        <label class="form-label">E-mail</label>
                    </div>

                    <div class="form-outline mt-3">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="***********" />
                        <label class="form-label">Password</label>
                    </div>

                    <div class="form-outline mt-3">
                        <input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="***********" />
                        <label class="form-label">Confirm Password</label>
                    </div>
                    <div class="form-text text-left">
                        Repeat your password again.
                    </div>
                    <input class="btn btn-primary btn-block mt-3" type="submit" value="Register" name="submit">
                </form>
                <div class="mt-4 text-center">
                    <p>Already have an account yet? <a href="<?php echo url('auth/login') ?>">Login Here</a></p>
                </div>
                <p class="text-muted mt-4 text-center">sHappy &copy 2023</p>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php' ?>