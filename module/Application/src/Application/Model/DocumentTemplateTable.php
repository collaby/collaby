<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

/**
 * Description of DocumentTemplateTable
 *
 * @author atila
 */
class DocumentTemplateTable {
   
   protected $tableGateway;
   
   public function __construct(TableGateway $tableGateway) {
      $this->tableGateway = $tableGateway;
   }
   
   public function create($document_id, $template_id) {
       $sql = "SELECT content FROM templates WHERE id = ?";
       $statement = $this->tableGateway->getAdapter()->createStatement($sql, array($template_id));
       $rs = $statement->execute();
       $row = $rs->current();
       $params = array(
           'document_id' => $document_id,
           'original_template_id' => $template_id,
           'content' => $row['content'],
       );
       $this->tableGateway->insert($params);
   }
}
