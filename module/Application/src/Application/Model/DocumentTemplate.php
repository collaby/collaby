<?php

namespace Application\Model;

use Core\Model\Entity;

/**
 * Description of DocumentTemplate
 *
 * @author atila
 */
class DocumentTemplate extends Entity {
   
   protected $tableName = 'document_templates';
   
   /**
    *
    * @var int
    */
   protected $document_id;
   
   /**
    *
    * @var int
    */
   protected $original_template_id;
   
   /**
    *
    * @var string
    */
   protected $content;
}
