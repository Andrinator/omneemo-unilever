<?php

namespace atoum\atoum\report\fields\runner;

require_once __DIR__ . '/../../../../constants.php';

use atoum\atoum\report;
use atoum\atoum\runner;

abstract class atoum extends report\field
{
    protected $author = null;
    protected $path = null;
    protected $version = null;

    public function __construct()
    {
        parent::__construct([runner::runStart]);
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function handleEvent($event, \atoum\atoum\observable $observable)
    {
        if (parent::handleEvent($event, $observable) === false) {
            return false;
        } else {
            $this->author = \atoum\atoum\author;
            $this->path = $observable->getScore()->getAtoumPath();
            $this->version = $observable->getScore()->getAtoumVersion();

            return true;
        }
    }
}