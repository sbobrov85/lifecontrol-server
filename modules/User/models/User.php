<?php
namespace Modules\User\Models;

use Modules\User\Models\Base\User as UserBase;

/**
 * Class User.
 *
 * Common user class.
 */
class User extends UserBase
{
    const
        ROLE_GUEST = 0,
        ROLE_USER = 1;
}
