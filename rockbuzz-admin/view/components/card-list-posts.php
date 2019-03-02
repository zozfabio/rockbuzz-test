<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/2/19
 * Time: 11:49 AM
 */

$tagNameMapper = function(\RockBuzz\Admin\Domain\Tag\TagResource $tag) {
    return $tag->getName();
};

/**
 * @var \Slim\Router $router
 * @var \RockBuzz\Admin\Domain\Post\PostResource[] $posts
 */
?>
<section class="card">
    <header>
        <h3>All Posts</h3>
    </header>
    <table>
        <thead>
        <tr>
            <th style="text-align: left;">Title</th>
            <th style="text-align: left;">Author</th>
            <th style="text-align: left;">Tags</th>
            <th style="text-align: left;">Published?</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $post) { ?>
        <tr>
            <td>
                <a href="<?php echo $router->pathFor("posts.findOne", ["id" => $post->getId()]) ?>">
                    <?php echo $post->getTitle() ?>
                </a>
            </td>
            <td><?php echo $post->getAuthor()->getName() ?></td>
            <td><?php echo implode(", ", array_map($tagNameMapper, $post->getTags())) ?></td>
            <td><?php echo $post->isPublished() ? "Yes" : "No" ?></td>
        </tr>
        <?php }  ?>
        </tbody>
    </table>
</section>
<?php
unset($tagNameMapper, $post);