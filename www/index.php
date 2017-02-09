<?php
const IMAGES_DIR = __DIR__ . "\images\gallery\\";

$container = require __DIR__ . '/../app/bootstrap.php';

$container->getByType(Nette\Application\Application::class)
	->run();
