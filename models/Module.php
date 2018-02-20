<?php
namespace Models;

use \Includes\CoreModel;

class Module extends CoreModel
{
    public $moduleId;

    public $name;

    public $version;

    //--------------------------------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public function columnMap(): array
    {
        return [
            'module_id' => 'moduleId',
            'name' => 'name',
            'version' => 'version',
        ];
    }
}
