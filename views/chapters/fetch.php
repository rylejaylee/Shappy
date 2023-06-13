<?php include_once 'views/layouts/header.php' ?>

<ul>
    <li><a href="/novel/fetch?novel=<?php echo $chapter->novel_slug ?>"><?php echo $chapter->novel_title ?></a></li>
    <li><?php echo $chapter->title ?></li>
</ul>

<h1><?php echo $chapter->title ?></h1>
<h5><?php echo $chapter->updated_at ?></h5>

<?php if (is_authorized() && is_owner($chapter->user_id)) : ?>
    <a href="/chapters/edit?id=<?php echo $chapter->id ?>">edit</a>
    <form id="delete_form">
        <input type="hidden" name="chapter_id" id="chapter_id" value="<?php echo $chapter->id; ?>">
        <input type="submit" value="delete">
    </form>
<?php endif; ?>


<p><?php echo $chapter->content ?></p>

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