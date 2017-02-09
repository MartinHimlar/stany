<?php

namespace App\FrontModule\Presenters;

use App\SiteNotFoundException;
use Nette;
use Nette\Utils\Finder;
use Nette\Utils\Image;

class HomepagePresenter extends BasePresenter
{

	public function actionDefault()
	{

        $images = [];
        foreach (Finder::findFiles("*.*")->in(IMAGES_DIR) as $filename => $fileObject) {
            $images["full"][] = str_replace("C:\\wamp\\www\\stany\\www", "", $filename);
        }
        foreach (Finder::findFiles("*.*")->in(IMAGES_DIR . "min\\") as $filename => $fileObject) {
            $images["min"][] = str_replace("C:\\wamp\\www\\stany\\www", "", $filename);
        }
        $this->template->images = $images;
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
