<?php

namespace App\AdminModule\Presenters;

use Nette;

class RolesPresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->title = 'Administrace';
	}

}
