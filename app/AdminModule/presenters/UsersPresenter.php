<?php

namespace App\AdminModule\Presenters;

use App\UserNotFoundException;
use Nette;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

class UsersPresenter extends BasePresenter
{

	public function actionDetail($id)
	{
		$user = $this->users->findUser($id);
		if (!$user) {
			$this->flashMessage('Neexistující uživatel!', 'warning');
			$this->redirect('default');
		}
		$this->template->row = $user;
	}

	public function actionDelete($id)
	{
		$user = $this->users->findUser($id);
		if (!$user) {
			$this->flashMessage('Neexistující uživatel!', 'warning');
		} else {
			$this->flashMessage('Uživatel byl úspěšně smazán.', 'success');
			$user->delete();
		}
		$this->redirect('default');
	}

	public function actionEdit($id)
	{
		$user = $this->users->findUser($id);
		if (!$user) {
			throw new BadRequestException();
		}
		$this['editUserForm']->setDefaults($user);
	}

	public function actionChangePublic($id)
	{
		$this->users->changeUserPublic($id);
		$this->flashMessage('Uživatel byl úspěšně změněn.', 'success');
		$this->redirect('default');
	}

	public function createComponentNewUserForm()
	{
		$form = new Form();

		$form->addText('nickname', 'Uživatelské jméno:')
			->setRequired('Uživatelské jméno musí být zadáno!');
		$form->addPassword('password', 'Heslo:')
			->setRequired('Heslo musí být zadáno!');
		$form->addPassword('passwordVerify', 'Heslo pro kontrolu:')
			->setRequired('Heslo pro kontrolu musí být zadáno')
			->addRule(Form::EQUAL, 'Hesla se neshodují', $form['password']);
		$form->addText('email', 'Emailová adresa:')
			->setRequired('Email musí být zadán')
			->addRule(Form::EMAIL, 'Zadali jste neplatný email platný email');
		$form->addText('name', 'Jméno');
		$form->addText('surname', 'Příjmení');

		$form->addSubmit('send', 'uložit')
			->setAttribute('class', 'btn btn-primary');

		$form->onSuccess[] = array($this, 'newUserFormSubmitted');

		return $form;
	}

	public function createComponentEditUserForm()
	{
		$form = new Form();

		$form->addText('nickname', 'Uživatelské jméno:')
			->setDisabled(TRUE)
			->setAttribute('class','form-control');
		$form->addText('email', 'Emailová adresa:')
			->setDisabled(TRUE)
			->setAttribute('class','form-control');
		$form->addText('name', 'Jméno')
			->setAttribute('class','form-control');
		$form->addText('surname', 'Příjmení')
			->setAttribute('class','form-control');
		$form->addHidden('id');

		$form->addSubmit('send', 'uložit')
			->setAttribute('class', 'btn btn-primary');
		$form->addSubmit('cancel', 'zrušit')
			->setAttribute('class', 'btn btn-default')
			->onClick[] = function () {
			$this->redirect('default');
		};

		$form->onSuccess[] = array($this, 'editUserFormSubmitted');

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function newUserFormSubmitted(Form $form)
	{
		$values = $form->getValues(TRUE);
		unset($values['passwordVerify']);
		try{
			$this->users->add($values);
		} catch (\Exception $e) {
			$this->flashMessage($e->getMessage(), 'error');
		}
		$this->redirect('default');
	}

	/**
	 * @param Form $form
	 * @throws UserNotFoundException
	 */
	public function editUserFormSubmitted(Form $form)
	{
		$values = $form->getValues(TRUE);
		try{
			$user = $this->users->findUser($values['id']);
			if (!$user) {
				throw new UserNotFoundException('Uživatel nenalezen');
			}
			unset($values['id']);
			$user->update($values);
			$this->flashMessage('Uživatel úspešně upraven', 'success');
		} catch (\Exception $e) {
			$this->flashMessage($e->getMessage(), 'error');
		}
		$this->redirect('default');
	}



    protected function createComponentUsersGrid($name)
    {
        $grid = new DataGrid($this, $name);
        $grid->setPrimaryKey('id');
        $grid->setDataSource($this->users->getAll()->fetchAll());
        $grid->addColumnNumber('id', 'id');
        $grid->addColumnText('name', 'jméno');
        $grid->addColumnText('surname', 'příjmení');
        $grid->addColumnText('nickname', 'přezdívka');
        $grid->addColumnNumber('public', 'aktivní');
        $grid->addAction('edit', 'editace')
            ->setClass('btn btn-primary btn-sm');
        $grid->addAction('changePublic', 'aktivace/deaktivace')
            ->setClass('btn btn-warning btn-sm');
        $grid->addAction('delete', 'smazat')
            ->setClass('btn btn-danger btn-sm');
    }

}
