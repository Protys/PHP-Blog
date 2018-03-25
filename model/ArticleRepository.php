<?php
    require_once 'GeneralRepository.php';

    class ArticleRepository extends GeneralRepository {

        public function __construct(Database $db) {
            parent::__construct($db);
            $this->setSql("SELECT ar.id id_article
            , au.id id_author
            , concat(au.name, ' ', au.surname) author
            , ar.category_id id_category
            , ar.title
            , ar.perex
            , ar.text
            , date_format(ar.created_at, '%e.%m.%Y %H:%i') date
            FROM article ar
            inner join author au on au.id = ar.author_id");
            $this->orderColumn = "ar.id";
        }

        public function getByAuthor(int $id_author) {
            $sql = $this->sql." where au.id = :id";
            
            $data = array(":id" => $id_author);

            return $this->db->SelectAll($this->orderBy($sql, "ar.id"), $data);
        }

        public function getByCategory(int $id_category) {
            $sql = $this->sql." where category_id = :id";
            
            $data = array(":id" => $id_category);
            return $this->db->SelectAll($this->orderBy($sql, "ar.id"), $data);
        }

        public function getByID(int $id) {
            $sql = $this->sql." where ar.id = :id";

            $data = array(":id" => $id);

            return $this->db->SelectOne($sql, $data);
        }

        public function add(array $data) {
            unset($data['id_article']);
            unset($data['date']);
            $text = $data['text'];
            $data = $this->checkForHTMLChars($data);
            $data['text'] = $text;
            $sql = "INSERT INTO article values (default, :id_author, :id_category, :title, :perex, :text, now())";

            $this->db->insert($sql, $data);
        }

        public function update(array $data) {
            unset($data['date']);
            $text = $data['text'];
            $data = $this->checkForHTMLChars($data);
            $data['text'] = $text;
            $sql = "UPDATE article SET author_id = :id_author, category_id = :id_category, title = :title, perex = :perex, text = :text WHERE id = :id_article";  
            
            $this->db->update($sql, $data);
        }

        public function remove(int $id) {
            $sql = "DELETE FROM article WHERE id = :id";
            
            $data = array(
                "id" => $id
            );
            $this->db->remove($sql, $data);
        }

    }
?>