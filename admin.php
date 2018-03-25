<?php
    require_once 'model/ArticleRepository.php';
    require_once 'model/CategoryRepository.php';
    require_once 'model/AuthorRepository.php';
    require_once 'model/Database.php';

    $db = new Database();

    $rep_article = new ArticleRepository($db);
    $rep_category = new CategoryRepository($db);
    $rep_author = new AuthorRepository($db);

    $articles = $rep_article->get();
    $authors = $rep_author->get();
    $categories = $rep_category->get();

    if(isset($_GET['error'])) {
        $flashMessage = "";
    }

    $title = "Admin";

    require_once 'layout.html';
?>
<?= $head ?>
<body>
    <?= $nav ?>

    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
        <div class="overlay">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>Administrace</h1>
                        <span class="subheading">-------</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
        <?php if(isset($_GET['error'])): ?>
            <div class="col-md-5 mx-auto">
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                    <strong>Chyba!</strong> Nelze odstranit kategorii nebo autora pokud mají aktivní články.
                </div>
                <hr>
            </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-md-5">
                <h2>Autoři</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jméno</th>
                            <th>Příjmení</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($authors as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><span><?= $item['name'] ?></span></td>
                            <td><span><?= $item['surname'] ?></span></td>
                            <td><a href="add_edit_author.php?id_author=<?= $item['id'] ?>">Edituj</a> | <a href="add_edit_author.php?id_author=<?= $item['id'] ?>&action=remove">Odstraň</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a class="btn btn-success" href="add_edit_author.php">Přidej Autora</a>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <h2>Kategoire</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jméno</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><span><?= $item['name'] ?></span></td>
                            <td><a href="add_edit_category.php?id_category=<?= $item['id'] ?>">Edituj</a> | <a href="add_edit_category.php?id_category=<?= $item['id'] ?>&action=remove">Odstraň</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a class="btn btn-success" href="add_edit_category.php">Přidej Kategorii</a>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <div class="row">
        <div class="col-md-9 mx-auto">
            <h2>Články</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulek</th>
                        <th>Perex</th>
                        <th>Akce</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($articles as $item): ?>
                    <tr>
                        <td><?= $item['id_article'] ?></td>
                        <td><span><?= $item['title'] ?></span></td>
                        <td><span><?= substr($item['perex'], 0, 70); ?></span></td>
                        <td><a href="add_edit_article.php?id_article=<?= $item['id_article'] ?>">Edituj</a> | <a href="add_edit_article.php?id_article=<?= $item['id_article'] ?>&action=remove">Odstraň</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a class="btn btn-success" href="add_edit_article.php">Přidej článek</a>
        </div>
    </div>
    <?= $script ?>
    <?= $foot ?>
</body>
</html>