<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/24/19
 * Time: 6:29 PM
 */

/**
 * @var array $filter
 * @var callable $removeFilterAuthorRoute
 * @var callable $removeFilterTagRoute
 */

if (!empty($filter["a"]) || !empty($filter["t"])) {
?>
<section class="card">
    <h3>Current Filter</h3>
    <?php if (isset($filter["a"])) { foreach ($filter["a"] as $author) { /** @var RockBuzz\Blog\Domain\Author\AuthorResource $author */ ?>
    <a href="<?php echo $removeFilterAuthorRoute($author) ?>">
        &times; Author <?php echo $author->getName() ?>
    </a>
    <br/>
    <?php } } ?>
    <?php if (isset($filter["t"])) { foreach ($filter["t"] as $tag) { /** @var RockBuzz\Blog\Domain\Tag\TagResource $tag */ ?>
    <a href="<?php echo $removeFilterTagRoute($tag) ?>">
        &times; Tag <?php echo $tag->getName() ?>
    </a>
    <br/>
    <?php } } ?>
</section>
<?
}