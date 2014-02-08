<?php

namespace Admin\Model;

use Application\Model\TemplateTable;
use Zend\Db\Sql\Select;

/**
 * Description of TemplateTable
 *
 * @author atila
 */
class AdminTemplateTable extends TemplateTable {
    
    public function listAll() {
        $sql = "SELECT t.id, t.description, t.document_type_id, dt.type, dt.type_abbr
            FROM templates t
            INNER JOIN document_types dt ON t.document_type_id = dt.id
            ORDER BY dt.type";
        $statement = $this->tableGateway->getAdapter()->createStatement($sql);
        return $statement->execute();
    }
}
