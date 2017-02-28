<?php

namespace App\FrontModule\Presenters;

use App\SiteNotFoundException;
use Photogallery\photogalleryManager;

class HomepagePresenter extends BasePresenter
{
    /**
     * @inject
     * @var photogalleryManager
     */
    public $photogallery;

	public function actionDefault($id = NULL)
	{
	    try {
	        if (count($id) < 1) { // wow, homepage hack :o)
	            $id = 1;
            }
            $site = $this->sites->getActive($id);
            $this->template->site = $site;
            if ((int) $id === 3) { //photogallery
                $this->template->images = $this->photogallery->findForFront();
            }
        } catch (SiteNotFoundException $e) {
	        $this->error('Stránka nenalezena!', 404);
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
