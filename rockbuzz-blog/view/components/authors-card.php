<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/24/19
 * Time: 6:33 PM
 */

/**
 * @var RockBuzz\Blog\Domain\Author\AuthorResource[] $authors
 * @var callable $filterAuthorRoute
 */

if (!empty($authors)) {
?>
<section class="card">
    <h3>Authors</h3>
    <?php foreach ($authors as $author) { ?>
        <a href="<?php echo $filterAuthorRoute($author) ?>">
            <?php echo $author->getName() ?>
        </a>
        <br/>
    <?php } ?>
</section>
<?php
}