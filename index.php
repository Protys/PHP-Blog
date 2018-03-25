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

    if (isset($_GET['id_author']) && is_numeric($_GET['id_author'])) {
      $id_author = (int)$_GET['id_author'];
      $articles = $rep_article->getByAuthor($id_author);
      $author = $rep_author->getByID($id_author);
      $filter['name'] = $author['name']." ".$author['surname'];
      $filter['filter'] = "Autor";
    } else if (isset($_GET['id_category']) && is_numeric($_GET['id_category'])) {
      $id_category = (int)$_GET['id_category'];
      $articles = $rep_article->getByCategory($id_category);
      $category = $rep_category->getByID($id_category);
      $filter['name'] = $category['name'];
      $filter['filter'] = "Kategorie";
    } else {
      $articles = $rep_article->get();
    }

    $title = "Home";

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
						<h1><?= isset($filter) ? $filter['name'] : "Novinky" ?></h1>
						<span class="subheading"><?= isset($filter) ? $filter['filter'] : "SSSVT" ?></span>
					</div>
				</div>
			</div>
		</div>
      </header>

    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
        <?php foreach($articles as $item): ?>
          <div class="post-preview">
            <a href="article.php?id_article=<?= $item['id_article'] ?>">
              <h2 class="post-title">
                <?= $item['title'] ?>
              </h2>
              <h3 class="post-subtitle">
                <?= $item['perex'] ?>
              </h3>
            </a>
            <p class="post-meta">Přidal(a)
              <a href="index.php?id_author=<?= $item['id_author'] ?>"><?= $item['author'] ?></a>
              dne <?= $item['date'] ?></p>
          </div>
          <hr>
        <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?= $script ?>
    <?= $foot ?>
</body>
</html>