<?php

namespace App\FrontModule\Presenters;

use Nette;
use Nette\Security\AuthenticationException;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{
	public function actionIn()
	{
		parent::startup();
		if ($this->user->loggedIn) {
			$this->redirect(':Admin:Homepage:default');
		}
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->redirect('Homepage:Default');
	}

}
