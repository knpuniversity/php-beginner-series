<?php

if ($_SERVER['REQUEST_METHOD']) {
    $name = $_POST['name'];
    $bio = $_POST['bio'];

    $newPet = array(
        'name' => $name,
        'bio' => $bio,
    );

    $json = json_encode($newPet);
    file_put_contents('new_pet.json', $json);

    header('Location: /');
}
?>
<?php require 'layout/header.php'; ?>

<h1>New Pet!</h1>

<form action="/pets_new.php" method="POST">

    <button type="submit">Add Pet!</button>
</form>

<?php require 'layout/footer.php'; ?>
