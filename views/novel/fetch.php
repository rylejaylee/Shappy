<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME ?></title>
</head>

<body>
    <?php if (session()->has('success')) : ?>
        <?php echo session()->get('success') ?>
    <?php endif; ?>

    <h1><?php echo $novel->title ?></h1>
    <img src="<?php echo $novel->img ? img($data['novel']->img) : img('novels/default.png') ?>" alt="<?php echo $novel->title ?>" height="170" width="120">
    <p><?php echo $novel->description ?></p>

    <h5><?php echo $novel->updated_at ?></h5>


    <?php if (is_authorized() && is_owner($novel->user_id)) : ?>
        <a href="/novel/edit?id=<?php echo $novel->id ?>">edit</a>
        <form id="delete_form">
            <input type="hidden" name="id" id="novel_id" value="<?php echo $novel->id; ?>">
            <input type="submit" value="delete">
        </form>
    <?php endif; ?>

    <hr>

    <a href="#">Add Chapter</a>

    <!-- list of chapters -->
    
    <!-- add ratings -->
    <!-- reviews -->
</body>


<script src="/assets//js/jquery3.7.0.min.js"></script>
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

</html>