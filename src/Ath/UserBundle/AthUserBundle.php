<?php

namespace Ath\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AthUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
