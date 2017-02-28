<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 10. 7. 2015
 * Time: 22:37
 */

namespace Sites;


use App\SiteNotAddedException;
use App\SiteNotFoundException;
use Nette\Database\Context;
use Nette\Object;

class SiteRepository extends Object
{
	/** @var Context $db */
	private $db;

	public function __construct(Context $database)
	{
		$this->db = $database;
	}

    /**
     * @return \Nette\Database\Table\Selection
     */
	public function findAll()
	{
		return $this->db->table('sites');
	}

    /**
     * @return mixed
     */
	public function findOtherAll()
    {
        return $this->findAll()
            ->where('default', 0);
    }

    /**
     * @return mixed
     */
	public function findOtherActive()
	{
		return $this->findOtherAll()
			->where('active', 1);
	}

    /**
     * @return array['order'] => 'title'
     */
	public function findMenuItems()
    {
        return $this->findAll()
            ->where('active', 1)
            ->order('order')
            ->fetchPairs('id', 'title');
    }

    /**
     * return array of url sites
     * @return array['id'] => 'url'
     */
    public function findForRouter()
    {
        return $this->findAll()
            ->fetchPairs('id', 'url');
    }

	public function get($id)
	{
		$row = $this->findAll()->where('id', $id)->fetch();

		if (!$row) {
			throw new SiteNotFoundException('Stránka nenalezena');
		}

		return $row;
	}

    public function getActive($id)
    {
        $row = $this->get($id);

        if (!$row || $row->active == FALSE) {
            throw new SiteNotFoundException('Stránka nenalezena');
        }

        return $row;
    }

	public function add($values)
	{
		$db = $this->findAll();

		if ($db->where('title', $values['title'])->fetch()) {
			throw new SiteNotAddedException('Existující název stránky');
		}
		$db->insert($values);
	}

	public function update($values)
	{
		$db = $this->findAll();
		$selection = clone $db;

		if ($db->where('title', $values['title'])->where('id NOT LIKE', $values['id'])->fetch()) {
			throw new SiteNotAddedException('Existující název stránky');
		}
		if ((int) $values['id'] === 1 || (int) $values['id'] === 2 || (int) $values['id'] === 3) {
		    $values['active'] = TRUE;
        }
		$selection->where('id', $values['id'])->update($values);
	}

	public function delete($id)
	{
		$row = $this->findAll()->where('id', $id);

		if (!$row->fetch()) {
			throw new SiteNotFoundException('Stránka nenalezena');
		}

		$row->delete();
	}
}