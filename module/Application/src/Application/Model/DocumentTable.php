<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

/**
 * Description of DocumentTable
 *
 * @author atila
 */
class DocumentTable {
   
   protected $tableGateway;
   protected $_sequence = 'documents_id_seq';

   public function __construct(TableGateway $tableGateway) {
      $this->tableGateway = $tableGateway;
   }

   public function listLastDocuments() {
      $sql = "SELECT d.id, name, real_name, type, type_abbr, created_at,
         to_char(created_at, 'HH24:MI - DD \"de\" Mon \"de\" YYYY') AS created_at_formated,
         ARRAY((SELECT tag FROM tags t
            INNER JOIN document_tags dtag ON d.id = dtag.document_id AND t.id = dtag.tag_id)) as tags
        FROM documents d
        INNER JOIN document_types dt ON d.document_type_id = dt.id
        INNER JOIN users u ON d.owner = u.id
        ORDER BY updated_at DESC, created_at DESC";
      
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
   
   public function fetchAll($columns = null, $where = null, $limit = null, $offset = null) {
      $select = new Select();
      $select->from($this->tableGateway->getTable());

      if ($columns) {
         $select->columns($columns);
      }

      if ($where) {
         $select->where($where);
      }

      if ($limit) {
         $select->limit((int) $limit);
      }

      if ($offset) {
         $select->offset((int) $offset);
      }

      return $this->selectWith($select);
   }

   public function getDocument($id)
   {
      $id  = (int) $id;
      $rowset = $this->tableGateway->select(array('id' => $id));
      $row = $rowset->current();
      if (!$row) {
         throw new \Exception("Could not find row $id");
      }
      return $row;
   }
}
