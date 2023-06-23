<?php include_once 'views/layouts/header.php' ?>
<?php
function status_color($status)
{
    return $status == 'completed' ? 'success' : ($status == 'ongoing' ? 'primary' : 'danger');
}
?>
<div class="row d-flex justify-content-center">

    <div class="col-lg-6 mt-5">
        <div class="card">
            <div class="card-header">
                <!-- header -->
                <div class="d-flex justify-content-between">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo url() ?>">Home</a></li>
                            <li class="breadcrumb-item "><a href="<?php echo url('novel/fetch?novel=' . $_GET['novel']) ?>">
                                    <?php echo $novel->title ?></a>
                            </li>
                            <li class="breadcrumb-item fw-bold">Chapters List</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    <h3><?php echo $novel->title ?> Chapters List</h3>
                    <hr class="hr">
                    <?php foreach ($chapters as $chapter) : ?>
                        <div class="d-flex justify-content-between align-items-center bg-light mt-2">
                            <div class="p-2  my-2">
                                <a href="<?php echo url("chapters/fetch?id=$chapter->id") ?>" class="text-dark">
                                    <span class="text-primary fw-bold"><?php echo $chapter->title ?></span>
                                    <small class="text-muted"><?php echo hummanDiff($chapter->updated_at) ?></small>
                                </a>

                            </div>
                            <?php if (is_authorized() && is_owner($novel->user_id)) : ?>
                                <div>
                                    <div class="d-flex">
                                        <a href="<?php echo url("chapters/edit?id=$chapter->id") ?>" class="btn btn-sm btn-outline-primary btn-floating me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>


                    <div class="d-flex justify-content-center w-100 mt-3">
                        <nav><?php echo $links ?></nav>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <?php include_once 'views/layouts/footer.php' ?>