<?php include_once 'views/layouts/header.php' ?>

<div class="row d-flex justify-content-center">
    <div class="col-lg-8 mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo url() ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="/novel/fetch?novel=<?php echo $chapter->novel_slug ?>">
                                    <?php echo $chapter->novel_title ?>
                                </a>
                            </li>
                            <li class="breadcrumb-item "><?php echo $chapter->title ?></li>
                        </ol>
                    </nav>
                    <div class="d-flex">
                        <?php if (is_authorized() && is_owner($chapter->user_id)) : ?>
                            <a href="<?php echo url("chapters/edit?id=$chapter->id") ?>" class="btn btn-primary btn-sm btn-floating me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="delete_form">
                                <input type="hidden" name="chapter_id" id="chapter_id" value="<?php echo $chapter->id; ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm btn-floating"><i class="fas fa-trash"></i></button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <hr class="hr">

                <div class="text-center">
                    <h3><?php echo $chapter->title ?></h3>
                    <small class="text-muted"><?php echo $chapter->updated_at ?></small>
                </div>

                <p><?php echo $chapter->content ?></p>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary"><< previous</button>
                    <button class="btn btn-primary">next >></button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php' ?>

<script>
    $(document).ready(() => {
        $("#delete_form").submit(function(e) {
            e.preventDefault();

            if (confirm("Are you sure you want to delete this novel?")) {
                let data = $(this).serialize();

                $.post("/chapters/delete", data, response => {
                    if (Number(response)) {
                        window.location = "/novel/fetch?novel=<?php echo $chapter->novel_slug ?>";
                    }
                }).fail((xhr, status, error) => {
                    console.log(xhr.responseText);
                });
            }
        })
    })
</script>