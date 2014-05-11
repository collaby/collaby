<?php

namespace Application\Model;

use Core\Model\Entity;

/**
 * Description of Document
 *
 * @author atila
 */
class Document extends Entity {

   protected $tableName = 'documents';

   /**
    *
    * @var int
    */
   protected $id;

   /**
    *
    * @var string
    */
   protected $name;

   /**
    *
    * @var string
    */
   protected $content;

   /**
    *
    * @var User
    */
   protected $owner;

   /**
    *
    * @var string
    */
   protected $template;

   /**
    *
    * @var datetime
    */
   protected $created_at;

   /**
    *
    * @var datetime
    */
   protected $updated_at;

   /**
    *
    * @var User
    */
   protected $updated_by;

   /**
    *
    * @var string
    */
   protected $url_to_share;

   /**
    *
    * @var DocumentType
    */
   protected $document_type;

   /**
    *
    * @var Document
    */
   protected $cloned_from;

}
