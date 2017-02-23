<?php

namespace App\AdminModule\Presenters;

use App\SiteNotAddedException;
use App\SiteNotFoundException;
use Nette;
use Nette\Application\UI\Form;
use Photogallery\ImageNotFoundExceptions;
use Photogallery\ImageNotOkExceptions;
use Photogallery\photogalleryManager;
use Sites\SiteRepository;
use Tracy\Debugger;
use Ublaboo\DataGrid\DataGrid;

class HomepagePresenter extends BasePresenter
{
	/** @var SiteRepository $sites */
	public $sites;

    /**
     * @inject
     * @var photogalleryManager
     */
	public $photogallery;

	public function __construct(SiteRepository $repository)
	{
		$this->sites = $repository;
	}

	public function startup()
	{
		parent::startup();
		$this->template->id = NULL;
		$this->template->siteTitle = 'Nová Stránka';
	}

	public function renderEditOther($id)
	{
		$this->template->setFile(__DIR__ . '/../templates/Homepage/addOther.latte');
		$this->template->id = $id;

		try {
			$site = $this->sites->get($id);
			if ($site->title) {
				$this->template->siteTitle = $site->title;
			}
			$this['siteForm']->setValues($site);
		} catch (SiteNotFoundException $e) {
			$this->flashMessage($e->getMessage(), 'error');
			$this->redirect('other');
		}
	}

	public function actionDeleteOther($id)
	{
		try {
			$this->sites->delete($id);
			$this->flashMessage('Stránka úspěšně smazána', 'success');
			$this->redirect('other');
		} catch (SiteNotFoundException $e) {
			$this->flashMessage('Stránka nelze smazat, již neexistuje');
			$this->redirect('other');
		}
	}

	public function actionEditOrderImages()
    {
        $this->template->images = $this->photogallery->findForAdministration()->where('active', 1);
    }

    public function handleSaveOrderImages($data)
    {
        try {
            $this->photogallery->changeOrderImages($data);
            $this->flashMessage('Úprava proběhla v pořádku :)', 'success');
            $this->redirect('editGallery');
        } catch (\PDOException $e) {
            $this->flashMessage('chyba databáze, nahlaš problém', 'danger');
            Debugger::log($e);
            $this->redirect('editOrderImages');
        }
    }

	public function actionDeleteImage($id)
    {
        try {
            $this->photogallery->removeImage($id);
            $this->flashMessage('Obrázek úspěšně smazán', 'warning');
            $this->redirect('editGallery');
        } catch (ImageNotFoundExceptions $e) {
            $this->flashMessage($e->getMessage(), 'danger');
            $this->redirect('editGallery');
        }

    }

    public function actionChangeImage($id)
    {
        try {
            $this->photogallery->changeAction($id);
            $this->flashMessage('Obrázek úspěšně změněn', 'success');
            $this->redirect('editGallery');
        } catch (ImageNotFoundExceptions $e) {
            $this->flashMessage($e->getMessage(), 'danger');
            $this->redirect('editGallery');
        }
    }

    public function handleAddOther($siteTitle)
	{
	    $siteTitle = Nette\Utils\Strings::webalize($siteTitle);
		$this['siteForm']['url']->setValue($siteTitle);
		$this->redrawControl('formInput');
	}

	public function createComponentSiteForm()
	{
		$form = new Form();

		$form->addText('title', 'Název:')
			->setHtmlId('siteTitle')
            ->setAttribute('placeholder', 'název')
			->setRequired('Název musí být vyplněn');

		$form->addText('url', 'Adresa:')
            ->setAttribute('placeholder', 'url')
            ->setAttribute('class', 'form-control mb-2 mr-sm-2 mb-sm-0')
			->setHtmlId('siteUrl');

		$form->addTextArea('content')
			->getControlPrototype()->id('siteTextarea')
			->setRequired('Obsah musí být vyplněn');

		$form->addCheckbox('active', 'Aktivní')
            ->setAttribute("class", "form-check-input")
		    ->setValue(TRUE);

		$form->addHidden('id', NULL);

		$form->addText('map_url', 'odkaz URL mapy:');

		$form->addSubmit('send', 'Uložit')
			->getControlPrototype()->class('btn btn-primary');

		$form->onSuccess[] = array($this, 'siteFormSuccessed');

		return $form;
	}

	public function siteFormSuccessed(Form $form)
	{
		$values = $form->getValues(TRUE);
		try {
			if ($values['id']) {
				$this->sites->update($values);
				$this->flashMessage('Stránka úspěšně upravena', 'success');
			} else {
			    unset($values['id']);
				$this->sites->add($values);
				$this->flashMessage('Stránka úspěšně vytvořena', 'success');
			}

			$this->redirect('other');
		} catch (SiteNotAddedException $e) {
			Debugger::log($e->getMessage());
			$this->flashMessage($e->getMessage(), 'error');
			$this->redirect('this');
		}
	}

	protected function createComponentSitesGrid($name)
    {
        $grid = new DataGrid($this, $name);
        $grid->setPrimaryKey('id');
        $grid->setDataSource($this->sites->findOtherAll()->fetchAll());
        $grid->addColumnNumber('id', 'id');
        $grid->addColumnText('title', 'Název');
        $grid->addColumnText('url', 'url');
        $grid->addColumnNumber('active', 'aktivní');
        $grid->addAction('editOther', 'upravit')
            ->setClass('btn btn-primary btn-sm');
        $grid->addAction('deleteOther', 'smazat')
            ->setClass('btn btn-danger btn-sm');
    }

    public function createComponentUploadForm()
    {
        $form = new Form();

        $form->addMultiUpload('upload', 'Vyber obrázky:')
            ->setAttribute('accept', 'image/*')
            ->addRule(Form::IMAGE, 'Některý ze souborů není obrázek typu JPEG, PNG nebo GIF.')
            ->addRule(Form::MAX_LENGTH, 'Můžeš nahrát maximálně 10 obrázků.', 10)
            ->setRequired('Musíš vybrat nějaký obrázek!');

        $form->addSubmit('send', 'nahraj')
            ->setAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = array($this, 'uploadFormSuccessed');

        return $form;
    }

    public function uploadFormSuccessed(Form $form)
    {
        $values = $form->getValues(TRUE);

        try {
            $this->photogallery->createImages($values['upload']);
            $this->flashMessage('Obrázky úspěšně nahrány', 'success');
            $this->redirect('this');
        } catch (ImageNotOkExceptions $e) {
            $this->flashMessage($e->getMessage(), 'danger');
        }
    }

    protected function createComponentGalleryGrid($name)
    {
        $grid = new DataGrid($this, $name);
        $grid->setPrimaryKey('id');
        $grid->setDataSource($this->photogallery->findForAdministration()->fetchAll());
        $grid->addColumnNumber('id', 'id');
        $grid->addColumnText('title', 'Název');
        $grid->addColumnText('filename', 'Název souboru');
        $grid->addColumnNumber('active', 'aktivní');
        $grid->addColumnNumber('order', 'pořadí');
        $grid->addAction('changeImage', 'aktivace/deaktivace')
            ->setClass('btn btn-warning btn-sm');
        $grid->addAction('deleteImage', 'smazat')
            ->setClass('btn btn-danger btn-sm');
    }
}
