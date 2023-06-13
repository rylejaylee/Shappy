<?php include_once 'views/layouts/header.php' ?>
<?php if (session()->has('success')) : ?>
    <?php echo session()->get('success') ?>
<?php endif; ?>

<h1><?php echo $novel->title ?></h1>
<h4>by: <?php echo $novel->name ?></h4>
<img src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png') ?>" alt="<?php echo $novel->title ?>" height="170" width="120">
<p><?php echo $novel->description ?></p>

<h5><?php echo $novel->updated_at ?></h5>

<?php if (is_authorized() && is_owner($novel->user_id)) : ?>
    <a href="/novel/edit?id=<?php echo $novel->id ?>">edit</a>
    <form id="delete_form">
        <input type="hidden" name="id" id="novel_id" value="<?php echo $novel->id; ?>">
        <input type="submit" value="delete">
    </form>
    <hr>

    <a href="/chapters/create?novel_id=<?php echo $novel->id ?>">Add Chapter</a>

<?php endif; ?>


<!-- list of chapters -->
<?php if (count($chapters)) : ?>
    <?php foreach ($chapters as $chapter) : ?>
        <h5>
            <a href="/chapters/fetch?id=<?php echo $chapter->id ?>"><?php echo $chapter->title ?></a>
            <small><?php echo $chapter->updated_at ?></small>
        </h5>
    <?php endforeach; ?>
<?php else : ?>
    <h3>No chapters added yet.</h3>
<?php endif; ?>



<!-- add ratings -->
<!-- reviews -->

<?php include_once 'views/layouts/footer.php' ?>

<script>
    $(document).ready(() => {
        $("#delete_form").submit(function(e) {
            e.preventDefault();

            if (confirm("Are you sure you want to delete this novel?")) {
                let data = $(this).serialize();

                $.post("/novel/delete", data, response => {
                    if (Number(response)) {
                        window.location = "/";
                    }
                }).fail((xhr, status, error) => {
                    console.log(xhr.responseText);
                });
            }
        })
    })
</script>