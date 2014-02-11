<?php

namespace Admin\Model;

use Application\Model\TemplateTable;

/**
 * Description of TemplateTable
 *
 * @author atila
 */
class AdminTemplateTable extends TemplateTable {
    
    public function listAll() {
        $sql = "SELECT t.id, t.description, t.document_type_id, dt.type, dt.type_abbr,
            t.html_editor_mode
            FROM templates t
            INNER JOIN document_types dt ON t.document_type_id = dt.id
            ORDER BY dt.type";
        $statement = $this->tableGateway->getAdapter()->createStatement($sql);
        return $statement->execute();
    }
    
    /**
     * 
     * @param array $params
     * @return int last generated value
     */
    public function create($params) {
        $this->tableGateway->insert($params);
        return $this->tableGateway->getAdapter()->getDriver()->getLastGeneratedValue($this->_sequence);
    }
    
    public function update($params, $id) {
        $where = array('id' => $id);
        $this->tableGateway->update($params, $where);
    }
    
    public function read($id) {
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
}
