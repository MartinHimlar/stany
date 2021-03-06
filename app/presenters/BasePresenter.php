<?php
use App\Users\UserManager;
use Sites\SiteRepository;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var UserManager */
	public $users;

	/** @var SiteRepository $sites */
	public $sites;

    public function injectAll(UserManager $userManager, SiteRepository $sites)
	{
		$this->users = $userManager;
		$this->sites = $sites;
	}

	public function startup()
    {
        parent::startup();
        $this->template->menu = $this->sites->findMenuItems();
    }

    public function flashMessage($message, $type = 'info')
	{
		switch ($type) {
			case 'error':
				$bootstrapType = 'alert-danger';
				break;
			case 'warning':
				$bootstrapType = 'alert-warning';
				break;
			case 'success':
				$bootstrapType = 'alert-success';
				break;
			default:
				$bootstrapType = 'alert-info';
				break;
		}
		parent::flashMessage($message, $bootstrapType);
	}

	public function beforeRender()
    {
        parent::beforeRender();
        $this->template->isLogged = $this->presenter->getUser()->loggedIn;
    }
}
