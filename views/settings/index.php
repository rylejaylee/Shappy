<?php include_once 'views/layouts/header.php' ?>
<?php
function status_color($status)
{
    return $status == 'completed' ? 'success' : ($status == 'ongoing' ? 'primary' : 'danger');
}
?>
<div class="row d-flex justify-content-center mt-5">

    <div class="col-md-7 col-lg-4">

        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div>
                    <?php echo session()->get('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">

                <h3 class="card-title">Settings</h3>
                <hr class="hr" />
                <?php if (session()->has('error')) { ?>
                    <p class="alert alert-danger text-center">
                        <?php echo session()->get('error') ?>
                    </p>
                <?php } ?>
                <p class="h5">Account Information</p>
                <form action="<?php echo url('users/update') ?>" method="POST">
                    <div class="form-outline mt-3">
                        <input type="text" name="name" class="form-control form-control-lg" value="<?php echo old('name') ?? $user->name ?? null ?>" />
                        <label class="form-label">Name</label>
                    </div>
                    <div class="form-outline mt-3">
                        <input type="text" name="email" class="form-control form-control-lg" value="<?php echo old('email') ?? $user->email ?>" />
                        <label class="form-label">E-mail</label>
                    </div>

                    <div class="form-outline mt-3">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="***********" />
                        <label class="form-label">New Password</label>
                    </div>

                    <div class="form-outline mt-3">
                        <input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="***********" />
                        <label class="form-label">Confirm Password</label>
                    </div>
                    <div class="form-text text-left">
                        Repeat your new password again.
                    </div>

                    <div class="form-outline mt-3">
                        <input type="password" name="old_password" class="form-control form-control-lg" placeholder="***********" />
                        <label class="form-label">Old Password</label>
                    </div>
                    <div class="form-text text-left">
                        This is your current/ old password. We need it to confirm if it is you.
                    </div>

                    <div class="d-flex justify-content-end">
                        <input class="btn btn-primary mt-3" type="submit" value="Update" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php' ?>