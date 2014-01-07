<?php

namespace Application\Model;

use Core\Model\Entity;

/**
 * Description of DocumentType
 *
 * @author atila
 */
class DocumentType extends Entity {
   
   protected $tableName = 'document_types';
   
   /**
    *
    * @var int
    */
   protected $id;
   
   /**
    *
    * @var string
    */
   protected $type;
}
