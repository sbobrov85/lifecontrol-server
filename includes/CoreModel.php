<?php
namespace Includes;

use Phalcon\Mvc\Model;

class CoreModel extends Model
{
    /**
     * Do some init actions on construct.
     */
    public function initialize()
    {
        // set core table prefix
        $manager = $this->getModelsManager();
        $manager->setModelPrefix('core_');
    }
}