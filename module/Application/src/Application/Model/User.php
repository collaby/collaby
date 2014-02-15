<?php

namespace Application\Model;

use Core\Model\Entity;

/**
 * Entidade User
 *
 */
class User extends Entity {

    /**
     * Nome da tabela. Campo obrigatório
     * @var string
     */
    protected $tableName = 'users';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $valid;

    /**
     * @var string
     */
    protected $role;
}
