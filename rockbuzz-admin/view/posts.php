<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/21/19
 * Time: 8:50 PM
 */

/**
 * @var \Slim\Router $router
 * @var string|null $message
 * @var \RockBuzz\Admin\Domain\Post\PostResource $selected
 */

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>The Greatest Band on Earth</title>
    <link rel="shortcut icon" type="image/png"
          href="http://rockbuzz.com.br/wp-content/uploads/2017/08/Logomarca_Grey_512px-06-06.png"/>
    <link rel="stylesheet" href="<?php echo "{$router->getBasePath()}/assets/styles.css" ?>"/>
</head>
<body>
<?php include "components/page-head.php" ?>

<nav>
    <a class="button" href="<?php echo $router->pathFor("logout") ?>">Log out</a>
    <a class="button" href="<?php echo $router->pathFor("posts.findAll") ?>">Posts</a>
</nav>

<?php if (isset($message) && !empty($message)) { ?>
<div class="alert">
    <strong>Success!</strong> <?php echo $message ?>
</div>

<?php } ?>
<section class="row"><?php
    include "components/card-list-posts.php";
    if (isset($selected)) {
        include "components/card-form-update.php";
    } else {
        include "components/card-form-insert.php";
    }
?></section>

<?php include "components/page-foot.php" ?>
</body>
</html>
