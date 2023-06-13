<?php include_once 'views/layouts/header.php'; ?>
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
<h3>Reviews</h3>
<?php if (session()->has('error')) : ?>
    <?php echo session()->get('error') ?>
<?php endif; ?>

<form action="/reviews/store" method="POST">
    <textarea name="comment" id="comment" cols="50" rows="5" placeholder="Enter your comment here..."></textarea> <br>
    <input type="hidden" name="novel_id" value="<?php echo $novel->id ?>">
    <input type="submit" value="submit" name="submit">
</form>

<!-- reviews list -->
<?php if (count($reviews)) : ?>
    <?php foreach ($reviews as $review) : ?>
        <h5><?php echo $review->name ?></h5>
        <p><?php echo $review->comment ?></p>
        <small><?php echo $review->updated_at ?></small>
        <hr>
    <?php endforeach; ?>
<?php else : ?>
    <h3>No reviews.</h3>
<?php endif; ?>

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