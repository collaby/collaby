<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Description of TemplateTable
 *
 * @author atila
 */
class TemplateTable {
   
   protected $tableGateway;
   protected $_sequence = 'templates_id_seq';
   
   public function __construct(TableGateway $tableGateway) {
      $this->tableGateway = $tableGateway;
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
   
   public function getTableGateway() {
      return $this->tableGateway;
   }
}
