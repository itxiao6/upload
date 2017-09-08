<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\File;
abstract class Base
{
    abstract public function upload(File $file, $newName = null);
    abstract public function getWebUrl();
}
