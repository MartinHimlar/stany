<?php
//require_once('.maintenance.php');

const IMAGES_DIR = __DIR__ . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "gallery" . DIRECTORY_SEPARATOR;

$container = require __DIR__ . '/../app/bootstrap.php';

$container->getByType(Nette\Application\Application::class)
	->run();
