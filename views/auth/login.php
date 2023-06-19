<?php include_once 'views/layouts/header.php' ?>

<div class="row d-flex justify-content-center align-items-center" style="height:100%">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <div class="card text-center">
            <div class="card-body">
                <h1 class="card-title">
                    <span class="text-primary">sHappy</span> - Login
                    <hr>
                </h1>

                <?php if (session()->has('warning')) { ?>
                    <p class="text-danger">
                        <?php echo session()->get('warning') ?>
                    </p>
                <?php } ?>
                <form action="<?php echo url('auth/login') ?>" method="POST">
                    <div class="form-outline">
                        <input type="text" name="email" class="form-control form-control-lg" value="<?php echo old('email') ?? null ?>" />
                        <label class="form-label">E-mail</label>
                    </div>

                    <div class="form-outline mt-3">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="***********" />
                        <label class="form-label">Password</label>
                    </div>

                    <input class="btn btn-primary btn-block mt-3" type="submit" value="LOGIN">
                </form>

                <div class="mt-4">
                    <p>Don't have an account yet? <a href="<?php echo url('auth/register')?>">Register Here</a></p>
                </div>
                <p class="text-muted">sHappy &copy 2023</p>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php' ?>