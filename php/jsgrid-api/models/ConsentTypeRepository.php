<?php
include "ConsentType.php";
class ConsentTypeRepository {
    protected $db;
    public function __construct(PDO $db) {
        $this->db = $db;
    }
    private function read($row) {
        $result = new ConsentType();
        $result->id = $row["id"];
        $result->type = $row["type"];
        return $result;
    }
    public function getById($id) {
        $sql = "SELECT * FROM consent_types WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }
    public function getAll($filter) {

	$type = isSet($filter["match_equal"]) ? $filter["type"] : "%" . $filter["type"] . "%";
	$id = $filter["id"];
        $sql = "SELECT * FROM consent_types WHERE type LIKE :type AND (:id = 0 OR id = :id)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":type", $type);
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
        $sql = "INSERT INTO consent_types (type) VALUES (:type)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":type", $data["type"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }
    public function update($data) {
        $sql = "UPDATE consent_types SET type = :type WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":type", $data["type"]);
        $q->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $q->execute();
    }
    public function remove($id) {
        $sql = "DELETE FROM consent_types WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }
}
?>
