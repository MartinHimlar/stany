<?php

namespace Photogallery;


use Nette\Http\FileUpload;
use Nette\Object;
use Nette\Utils\DateTime;
use Nette\Utils\Image;
use Nette\Utils\Json;

class photogalleryManager extends Object
{
    /**
     * @var photogalleryRepository
     */
    private $repository;

    public function __construct(photogalleryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * return all rows from database
     * @return \Nette\Database\Table\Selection
     */
    public function findForAdministration()
    {
        return $this->repository->find()
            ->order('order');
    }

    /**
     * delete image by id
     * @param $id
     */
    public function removeImage($id)
    {
        $filename = $this->repository->removeImage($id);
        unlink(IMAGES_DIR . $filename);
        unlink(IMAGES_DIR . 'min' . DIRECTORY_SEPARATOR . $filename);
    }


    public function changeOrderImages($data)
    {
        $values = Json::decode($data, ":");
        foreach ($values as $order => $id)
        {
            $this->repository->update((int) $id, array("order" => $order));
        }
    }

    /**
     * change action of image
     * @param int $id
     */
    public function changeAction($id)
    {
        $this->repository->changeActivImage($id);
    }

    /**
     * @param $data
     */
    public function createImages($data)
    {
        $error = 0;
        /**
         * @var FileUpload $file
         */
        foreach ($data as $file)
        {
            if (!$file->isOk() || !$file->isImage()) {
                $error++;
            } else {
                $image = $file->toImage();
                $date = new DateTime();
                $filename = $date->format('dmY_His') . $file->getSanitizedName();
                $this->createThumbnail($image, $filename);
                $image->save(IMAGES_DIR . $filename);
                $this->repository->add(array(
                    'filename' => $filename,
                    'title' => pathinfo($filename)['filename'],
                    'active' => 1,
                    'order' => 999,
                ));
            }
        }

        if ($error > 0) {
            throw new ImageNotOkExceptions('Nebylo možné nahrát ' . $error . ' souborů. Poškozené soubory nebo nesprávný formát!');
        }
    }

    /**
     * create and save thumbnail
     * @param Image $image
     */
    private function createThumbnail(Image $image, $filename)
    {
        $thumbnail = clone $image;
        if ($thumbnail->height > $thumbnail->width)
            $thumbnail->resize(NULL, 200);
        else
            $thumbnail->resize(200, NULL);

        $thumbnail->save(IMAGES_DIR . 'min' . DIRECTORY_SEPARATOR . $filename);
    }
}
class ImageNotOkExceptions extends \RuntimeException {}
