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

   /**
    * Used in
    *    / [application/index/index]
    */
   public function listLastDocuments() {
      return "SELECT d.id, name, real_name, type, type_abbr, created_at,
         to_char(created_at, 'DD \"de\" Mon \"de\", YYYY - HH24:MI') AS created_at_formated,
         ARRAY((SELECT tag FROM tags t
            INNER JOIN document_tags dtag ON d.id = dtag.document_id AND t.id = dtag.tag_id)) as tags
        FROM documents d
        INNER JOIN document_types dt ON d.document_type_id = dt.id
        INNER JOIN users u ON d.owner = u.id
        ORDER BY updated_at DESC, created_at DESC";
   }

}
