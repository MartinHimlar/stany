<?php

namespace Photogallery;

CONST TABLE_NAME = 'photogallery';

use Nette\Database\Context;
use Nette\Object;

class photogalleryRepository extends Object
{
    /** @var Context  */
    private $db;

    public function __construct(Context $connection)
    {
      $this->db = $connection;
    }

    /**
     * Find collection of images
     * @return \Nette\Database\Table\Selection
     */
    public function find()
    {
        return $this->db->table(TABLE_NAME);
    }

    private function getRow($id)
    {
        $selection = $this->find()->where('id', $id);

        if ($selection->count() < 1) {
            throw new ImageNotFoundExceptions('Nelze pracovat s obrázkem. Neexistuje!');
        }

        return $selection;
    }

    /**
     * update data in database
     * @param array $data [id => order]
     */
    public function update($id, $data)
    {
        $selection = $this->find();
        $selection = $selection->where('id', $id);
        $selection->update($data);
    }

    /**
     * Get current row of image
     * @param int $id
     * @return \Nette\Database\Table\IRow
     */
    public function get($id)
    {
        $row = $this->find()->get($id);

        if (!$row) {
            throw new ImageNotFoundExceptions('Obrázek nelze najít');
        }

        return $row;
    }

    /**
     * invert activation of image
     * @param int $id
     */
    public function changeActivImage($id)
    {
        $row = $this->getRow($id);
        $active = $row->fetch();

        $row->update(array(
            'active' => !$active->active
        ));
    }

    /**
     * Delete image from database
     * @param int $id
     * @return string
     */
    public function removeImage($id)
    {
        $selection = $this->getRow($id);
        $filename = $selection->fetch();
        $filename = $filename->filename;
        $selection->delete();
        return $filename;
    }

    /**
     * @param array $values
     */
    public function add($values)
    {
        $this->find()->insert($values);
    }
}

class ImageNotFoundExceptions extends \RuntimeException {}
