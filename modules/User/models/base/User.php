<?php
namespace Modules\User\Models\Base;

use \Phalcon\Db\Column as Column;
use Includes\ModuleModel;

/**
 * Class User.
 *
 * Base users model (database layer).
 */
class User extends ModuleModel
{
    /**
     * {@inheritDoc}
     */
    public static function getTableColumns(): array
    {
        return [
            new Column('id', [
                'type' => Column::TYPE_INTEGER,
                'size' => 11,
                'notNull' => true,
                'autoIncrement' => true,
                'primary' => true
            ]),
            new Column('login', [
                'type' => Column::TYPE_VARCHAR,
                'size' => 128,
                'notNull' => true
            ]),
            new Column('password', [
                'type' => Column::TYPE_VARCHAR,
                'size' => 256,
                'notNull' => true
            ])
        ];
    }
}
