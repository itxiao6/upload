<?php
namespace Itxiao6\Upload\Validation;
use Itxiao6\Upload\Validation\Base;
use Itxiao6\Upload\File;

class Mimetype extends Base
{
    /**
     * Valid media types
     * @var array
     */
    protected $mimetypes;

    /**
     * Error message
     * @var string
     */
    protected $message = 'Invalid mimetype';

    /**
     * Constructor
     * @param array $mimetypes Array of valid mimetypes
     */
    public function __construct($mimetypes)
    {
        if (!is_array($mimetypes)) {
            $mimetypes = array($mimetypes);
        }
        $this->mimetypes = $mimetypes;
    }

    /**
     * Validate
     * @param  File $file
     * @return bool
     */
    public function validate(File $file)
    {
        return in_array($file->getMimetype(), $this->mimetypes);
    }
}
