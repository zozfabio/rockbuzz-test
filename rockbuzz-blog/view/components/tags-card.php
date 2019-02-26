<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/24/19
 * Time: 6:31 PM
 */

/**
 * @var RockBuzz\Blog\Domain\Tag\TagResource[] $tags
 * @var callable $filterTagRoute
 */

if (!empty($tags)) {
?>
<section class="card">
    <h3>Tags</h3>
    <?php foreach ($tags as $tag) { ?>
        <a href="<?php echo $filterTagRoute($tag) ?>">
            <?php echo $tag->getName() ?>
        </a>
        <br/>
    <?php } ?>
</section>
<?php
}