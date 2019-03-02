<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/21/19
 * Time: 8:50 PM
 */

/**
 * @var \Slim\Router $router
 * @var string $error
 * @var string $username
 */
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="shortcut icon" type="image/png"
          href="http://rockbuzz.com.br/wp-content/uploads/2017/08/Logomarca_Grey_512px-06-06.png"/>
    <link rel="stylesheet" href="<?php echo "{$router->getBasePath()}/assets/styles.css" ?>"/>
</head>
<body>
<form method="post" action="<?php echo $router->pathFor("login.post") ?>">
    <?php if ($error) { ?>
        <div class="alert">
            <strong>Ups!</strong> <?php echo $error ?>
        </div>
    <?php } ?>
    <div class="form-control">
        <input type="text" name="username" value="<?php echo $username ?>" placeholder="your login..." <?php echo $username ? "" : "autofocus" ?>/>
    </div>
    <div class="form-control">
        <input type="password" name="password" placeholder="your password..." <?php echo $username ? "autofocus" : "" ?>/>
    </div>
    <div class="form-control">
        <button type="submit">Login</button>
    </div>
</form>
</body>
</html>