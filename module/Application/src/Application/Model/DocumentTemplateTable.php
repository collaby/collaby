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
}
