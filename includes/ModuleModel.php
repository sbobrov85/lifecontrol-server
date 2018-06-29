<?php
namespace Includes;

use Phalcon\Mvc\Model;

/**
 * Class ModuleModel.
 *
 * Base model for all application modules.
 */
abstract class ModuleModel extends Model
{
    /**
     * Do some init actions on construct.
     */
    public function initialize()
    {
        // set module table prefix
        $manager = $this->getModelsManager();
        // $manager->setModelPrefix($this->getModulePrefix());
    }

    //--------------------------------------------------------------------------

    /**
     * Geting database columns description from colums property.
     *
     * @link https://docs.phalconphp.com/en/latest/db-layer#creating-tables
     *
     * @return array columns descriptions or empty array.
     */
    abstract public static function getTableColumns(): array;
}
