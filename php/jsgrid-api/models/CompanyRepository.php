<?php
include "Company.php";
class CompanyRepository {
    protected $db;
    public function __construct(PDO $db) {
        $this->db = $db;
    }
    private function read($row) {
        $result = new Company();
        $result->id = $row["id"];
        $result->name = $row["name"];
        return $result;
    }
    public function getById($id) {
        $sql = "SELECT * FROM companies WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }
    public function getAll($filter) {
	$name = isSet($filter["match_equal"]) ? $filter["name"] : "%" . $filter["name"] . "%";
	$id = $filter["id"];
        $sql = "SELECT * FROM companies WHERE name LIKE :name AND (:id = 0 OR id = :id)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":name", $name);
        $q->bindParam(":id", $id);
        $q->execute();
        $rows = $q->fetchAll();
        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }
    public function insert($data) {
        $sql = "INSERT INTO companies (name) VALUES (:name)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":name", $data["name"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }
    public function update($data) {
        $sql = "UPDATE companies SET name = :name WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":name", $data["name"]);
        $q->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $q->execute();
    }
    public function remove($id) {
        $sql = "DELETE FROM companies WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }
}
?>
