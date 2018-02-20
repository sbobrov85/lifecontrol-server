<?php
namespace Includes;

require_once('../../Install.php');

use
    Phalcon\Mvc\Model;

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
        $manager->setModelPrefix(Install::getModulePrefix());
    }
}
