<?php

    abstract class GeneralRepository {
        
        protected $db;

        protected $sql;

        protected $orderColumn;

        public function __construct(Database $db) {
            $this->db = $db;
        }

        protected final function setSql($sql) {
            $this->sql = $sql;
        }

        protected function orderBy(string $sql, string $column) {
            return $sql." order by ".$column;
        }

        public function get(int $count = null) {
            $sql = $this->sql." order by ".$this->orderColumn;
            if ($count !== null)
                $sql = $sql." limit ".$count;

            return $this->db->SelectAll($sql);
        }

        protected function checkForHTMLChars(array $data) {
            foreach($data as $key => $item) {
                $data[$key] = htmlspecialchars($item);
            }
            return $data;
        }

        abstract function update(array $data);

        abstract function remove(int $id);

        abstract function add(array $data);
    }
?>