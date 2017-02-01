<?php

namespace App\FrontModule\Presenters;

use App\SiteNotFoundException;
use Nette;

class HomepagePresenter extends BasePresenter
{

	public function actionDefault()
	{
	    try{
            $this->template->site = $this->sites->get(1);
        } catch (SiteNotFoundException $e) {
	        $this->redirect('Error:Default', new Nette\Application\BadRequestException('Page not found', 404, $e));
        }
	}

	public function renderContacts()
	{
		$this->template->site = $this->sites->get(3);
		$this->template->map = $this->sites->get(2);
	}

	public function actionSite($id)
	{
		$this->template->site = $this->sites->get($id);
	}

}
