<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/21/19
 * Time: 8:50 PM
 */

/**
 * @var \Slim\Router $router
 * @var RockBuzz\Blog\Domain\Post\PostResource $post
 */
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>The Greatest Band on Earth</title>
    <link rel="shortcut icon" type="image/png" href="http://rockbuzz.com.br/wp-content/uploads/2017/08/Logomarca_Grey_512px-06-06.png"/>
    <link rel="stylesheet" href="<?php echo "{$router->getBasePath()}/assets/styles.css" ?>"/>
</head>
<body>
<?php include "components/page-head.php" ?>
<nav>
    <a href="<?php echo $router->pathFor("posts.findAll") ?>">All Posts</a>
    /
    <a href="<?php echo $router->pathFor("posts.findOneBySlug", ["slug" => $post->getSlug()]) ?>"><?php echo $post->getTitle() ?></a>
</nav>
<section class="row">
    <aside>
        <?php include "components/about-section.php" ?>
    </aside>
    <section id="post-section">
        <h3>Details</h3>
        <article>
            <header>
                <h3><?php echo $post->getTitle() ?></h3>
            </header>
            <p><?php echo $post->getBody() ?></p>
        </article>
    </section>
</section>
<?php include "components/page-foot.php" ?>
</body>
</html>