<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/21/19
 * Time: 8:50 PM
 */

/**
 * @var \Slim\Router $router
 * @var RockBuzz\Blog\Domain\Post\PostResource[] $posts
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
    <a href="<?php echo $router->pathFor("posts.findAll") ?>">All Posts</a>
</nav>
<section class="row">
    <aside>
        <?php
        include "components/about-section.php";
        include "components/current-filter-card.php";
        include "components/authors-card.php";
        include "components/tags-card.php";
        ?>
    </aside>
    <section id="posts-section">
        <h3>Posts</h3>
        <?php if (empty($posts)) { ?>
        <article>
            <header>
                <h3>No posts found!</h3>
            </header>
            <p>Remove some filter on the left to see something.</p>
        </article>
        <?php } else { foreach ($posts as $post) { ?>
        <article>
            <header>
                <h3><?php echo $post->getTitle() ?></h3>
            </header>
            <p><?php echo $post->getSummary() ?></p>
            <footer>
                <a href="<?php echo $router->pathFor("posts.findOneBySlug", ["slug" => $post->getSlug()]) ?>">Read
                    More</a>
            </footer>
        </article>
        <?php } } ?>
    </section>
</section>
<?php include "components/page-foot.php" ?>
</body>
</html>