<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/2/19
 * Time: 11:46 AM
 */

/**
 * @var \Slim\Router $router
 * @var string|null $formError
 * @var array|null $formData
 * @var \RockBuzz\Admin\Domain\Author\AuthorResource[] $authors
 * @var \RockBuzz\Admin\Domain\Tag\TagResource[] $tags
 */

$postTitle     = $formData["title"] ?: "";
$postSlug      = $formData["slug"] ?: "";
$postBody      = $formData["body"] ?: "";
$postPublished = $formData["published"] ?: "";
$postAuthor    = $formData["author"] ?: "";
$postTags      = $formData["tags"] ?: [];
?>
<section class="card">
    <header>
        <h3>Insert Post</h3>
    </header>
    <?php if (isset($formError) && !empty($formError)) { ?>
        <div class="alert">
            <strong>Ups!</strong> <?php echo $formError ?>
        </div>
    <?php } ?>
    <form method="post" action="<?php echo $router->pathFor("posts.insert") ?>">
        <div class="form-control">
            <label for="post-title">Title</label>
            <input type="text"
                   id="post-title"
                   name="title"
                   placeholder="post title..."
                <?php echo $postTitle ? "value=\"{$postTitle}\"" : "" ?>/>
        </div>
        <div class="form-control">
            <label for="post-slug">Slug</label>
            <input type="text"
                   id="post-slug"
                   name="slug"
                   placeholder="post slug..."
                <?php echo $postSlug ? "value=\"{$postSlug}\"" : "" ?>/>
        </div>
        <div class="form-control">
            <label for="post-body">Body</label>
            <textarea id="post-body" name="body">
                <?php echo $postBody ?>
            </textarea>
        </div>
        <div class="form-control">
            <label for="post-published">Published?</label>
            <input type="checkbox"
                   id="post-published"
                   name="published"
                <?php echo $postPublished ? "checked" : "" ?>/>
        </div>
        <div class="form-control">
            <label for="post-author">Author</label>
            <select id="post-author" name="author">
                <option value=""></option>
                <?php foreach ($authors as $author) { ?>
                    <option value="<?php echo $author->getId() ?>"
                        <?php echo $postAuthor == $author->getId() ? "selected" : "" ?>>
                        <?php echo $author->getName() ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-control">
            <label for="post-tags">Tags</label>
            <select id="post-tags" name="tags[]" multiple>
                <?php foreach ($tags as $tag) { ?>
                    <option value="<?php echo $tag->getId() ?>"
                        <?php echo in_array($tag->getId(), $postTags) ? "selected" : "" ?>>
                        <?php echo $tag->getName() ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-control">
            <button type="reset">Reset</button>
            <button type="submit">Confirm</button>
        </div>
    </form>
</section>

<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector("form #post-body"))
        .catch(error => console.error(error));
</script>
<?php
unset($postTitle, $postSlug, $postBody, $postPublished, $postAuthor, $postTags, $author, $tag);