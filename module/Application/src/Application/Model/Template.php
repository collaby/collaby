<?php

namespace Application\Model;

use Core\Model\Entity;

/**
 * Description of Template
 *
 * @author atila
 */
class Template extends Entity {
   
   protected $tableName = 'templates';
   
   /**
    *
    * @var int
    */
   protected $id;
   
   /**
    *
    * @var string
    */
   protected $description;
   
   /**
    *
    * @var string
    */
   protected $content;
   
   /**
    * @var DocumentType
    */
   protected $documentType;
}
