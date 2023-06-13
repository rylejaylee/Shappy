<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME ?> - Edit Novel </title>
</head>
<body>
    <h1>Edit Novel</h1>

    <?php if (session()->has('error')) { ?>
        <?php echo session()->get('error') ?>
    <?php } ?>

    <form action="/novel/update?id=<?php echo $novel->id ?>" method="POST">
        <input type="hidden" name="novel_id" value="<?php echo $novel->id; ?>">
        <label for="title">Title</label>
        <input type="text" name="title" value="<?php echo old('title') ?? $novel->title ?>"><br>
        <label for="desc">Description</label>
        <textarea name="desc" id="desc" cols="30" rows="10"><?php echo old('desc') ?? $novel->description  ?></textarea>
        <input type="submit" value="update">
    </form>
</body>

</html>