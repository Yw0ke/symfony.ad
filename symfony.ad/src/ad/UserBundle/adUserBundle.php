<?php

namespace ad\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class adUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
