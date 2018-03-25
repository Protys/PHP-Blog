<?php
    require_once 'GeneralRepository.php';

    class AuthorRepository extends GeneralRepository {

        public function __construct(Database $db) {
            parent::__construct($db);
            $this->setSql("SELECT * FROM author");
            $this->orderColumn = "id";
        }

        public function getByID(int $id) {
            $sql = $this->sql." where id = :id";

            $params = array(":id" => $id);

            return $this->db->SelectOne($sql, $params);
        }

        public function remove(int $id) {
            $sql = "SELECT id FROM article WHERE author_id = :id";

            $data = array(
                "id" => $id
            );
            
            if (empty($this->db->selectOne($sql, $data))) {
                $sql = "DELETE FROM author WHERE id = :id";

                $this->db->remove($sql, $data);
                return false;
            }
            return true;
        }

        public function add(array $data) {
            unset($data['id']);
            $sql = "INSERT INTO author values (default, :name, :surname)";

            $this->db->insert($sql, $this->checkForHTMLChars($data));
        }

        public function update(array $data) {
            $sql = "UPDATE author SET name = :name, surname = :surname WHERE id = :id";
            
            $this->db->update($sql, $this->checkForHTMLChars($data));
        }

    }
?>