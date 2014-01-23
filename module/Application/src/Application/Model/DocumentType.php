<?php

namespace Application\Model;

use Core\Model\Entity;

/**
 * Description of DocumentType
 *
 * @author atila
 */
class DocumentType extends Entity {
   
   const latex = 1;
   const beamer = 2;
   
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
