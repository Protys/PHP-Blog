<?php
    require_once 'model/ArticleRepository.php';
    require_once 'model/CategoryRepository.php';
    require_once 'model/AuthorRepository.php';
    require_once 'model/Database.php';

    $db = new Database();

    $rep_article = new ArticleRepository($db);
    $rep_category = new CategoryRepository($db);
    $rep_author = new AuthorRepository($db);

    $authors = $rep_author->get();
    $categories = $rep_category->get();

    if(isset($_GET['id_article']) && is_numeric($_GET['id_article'])) {
        $article = $rep_article->getByID((int)$_GET['id_article']);

        if(isset($_GET['action']) && $_GET['action'] === "remove") {

            if ($rep_article->remove((int)$article['id_article'])) {
                header("Location: admin.php");
                die();
            }
            header("Location: admin.php");
            die();
        }
    }

    if(!empty($_POST)) {
        if(empty($rep_article->getByID((int)$_POST['id_article'])))
            $rep_article->add($_POST);
        else
            $rep_article->update($_POST);
        header("Location: admin.php");
        die();
    }

    $title = (isset($article) ? "Edit" : "Add")." Article";

    require_once 'layout.html';
?>
<?= $head.'<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:"#text"});</script>' ?>
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
                        <span class="subheading">Článku</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <form method="POST">
                <input hidden name="id_article" value="<?= isset($article) == true ? $article['id_article'] : "" ?>" >
                <input hidden name="date" value="<?= isset($article) == true ? $article['date'] : "" ?>" >

                <div class="control-group">
                    <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" required data-validation-required-message="Fill perex." name="title" value="<?= isset($article) == true ? $article['title'] : "" ?>">
                    <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group">
                    <label>Perex</label>
                    <textarea rows="3" name="perex" class="form-control" required data-validation-required-message="Fill perex."><?= isset($article) == true ? $article['perex'] : "" ?></textarea>
                    <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group">
                    <label>Text</label>
                    <textarea rows="7" name="text" id="text" class="form-control" data-validation-required-message="Fill text."><?= isset($article) == true ? $article['text'] : "" ?></textarea>
                    <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group">
                    <label>Autor</label>
                    <select class="form-control" name="id_author">
                        <option selected disabled>Vyberte autora</option>
                    <?php foreach($authors as $item): ?>
                        <option <?= isset($article) == true && $article['id_author'] == $item['id'] ? "selected" : "" ?> value="<?= $item['id'] ?>"><?= $item['name']." ".$item['surname'] ?></option>
                    <?php endforeach; ?>
                    </select>
                    <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group">
                    <label>Kategorie</label>
                    <select class="form-control" name="id_category">
                        <option selected disabled>Vyberte kategorii</option>
                    <?php foreach($categories as $item): ?>
                        <option <?= isset($article) == true && $article['id_category'] == $item['id'] ? "selected" : "" ?> value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                    <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Save</button>
                    <a href="admin.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
      </div>
    </div>
    <?= $foot ?>
    <?= $script ?>
</body>
</html>