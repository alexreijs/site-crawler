<?php

include "Rule.php";
class RuleRepository {
    protected $db;
    public function __construct(PDO $db) {
        $this->db = $db;
    }
    private function read($row) {
        $result = new Rule();
        $result->id = intval($row["id"]);
        $result->type = intval($row["type"]);
        $result->priority = intval($row["priority"]);
        $result->location = $row["location"];
        $result->value = $row["value"];
        $result->company_id = intval($row["company_id"]);
        $result->consent_type_id = intval($row["consent_type_id"]);
        $result->operator = intval($row["operator"]);

        return $result;
    }
    public function getById($id) {
        $sql = "SELECT * FROM rules WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }
    public function getAll($filter) {
	$id = $filter["id"];
	$type = $filter["type"];
	$priority = $filter["priority"];
	$location = '%' . $filter["location"] . '%';
	$value = '%' . $filter["value"] . '%';
	$company_id = $filter["company_id"];
	$consent_type_id = $filter["consent_type_id"];
	$operator = $filter["operator"];

        $sql = "SELECT * FROM rules WHERE location LIKE :location AND value like :value AND (:company_id = 0 OR company_id = :company_id) AND (:type = 0 or type = :type) AND (:consent_type_id = 0 OR consent_type_id = :consent_type_id) AND (:operator = 0 OR operator = :operator)";

        $q = $this->db->prepare($sql);
        $q->bindParam(":type", $type);
        $q->bindParam(":priority", $priority);
        $q->bindParam(":location", $location);
        $q->bindParam(":value", $value);
        $q->bindParam(":company_id", $company_id, PDO::PARAM_INT);
        $q->bindParam(":consent_type_id", $consent_type_id);
        $q->bindParam(":operator", $operator);
        $q->execute();
        $rows = $q->fetchAll();
        $result = array();

        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }
    public function insert($data) {
        $sql = "INSERT INTO rules (type, priority, location, value, company_id, consent_type_id, operator) VALUES (:type, :priority, :location, :value, :company_id, :consent_type_id, :operator)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":type", $data["type"]);
        $q->bindParam(":priority", $data["priority"]);
        $q->bindParam(":location", $data["location"]);
        $q->bindParam(":value", $data["value"]);
        $q->bindParam(":company_id", $data["company_id"]);
        $q->bindParam(":consent_type_id", $data["consent_type_id"]);
        $q->bindParam(":operator", $data["operator"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }
    public function update($data) {
        $sql = "UPDATE rules SET type = :type, priority = :priority, location = :location, value = :value, company_id = :company_id, consent_type_id = :consent_type_id, operator = :operator WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":type", $data["type"]);
        $q->bindParam(":priority", $data["priority"]);
        $q->bindParam(":location", $data["location"]);
        $q->bindParam(":value", $data["value"]);
        $q->bindParam(":company_id", $data["company_id"]);
        $q->bindParam(":consent_type_id", $data["consent_type_id"]);
        $q->bindParam(":operator", $data["operator"]);
        $q->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $q->execute();
    }
    public function remove($id) {
        $sql = "DELETE FROM rules WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }
}
?>
