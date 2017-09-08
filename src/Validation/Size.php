<?php
namespace Itxiao6\Upload\Validation;
use Itxiao6\Upload\Validation\Base;
use Itxiao6\Upload\File;

class Size extends Base
{
    /**
     * Minimum acceptable file size (bytes)
     * @var int
     */
    protected $minSize;

    /**
     * Maximum acceptable file size (bytes)
     * @var int
     */
    protected $maxSize;

    /**
     * Error message
     * @var string
     */
    protected $message = 'Invalid file size';

    /**
     * Constructor
     * @param int $maxSize Maximum acceptable file size in bytes (inclusive)
     * @param int $minSize Minimum acceptable file size in bytes (inclusive)
     */
    public function __construct($maxSize, $minSize = 0)
    {
        if (is_string($maxSize)) {
            $maxSize = File::humanReadableToBytes($maxSize);
        }
        $this->maxSize = $maxSize;

        if (is_string($minSize)) {
            $minSize = File::humanReadableToBytes($minSize);
        }
        $this->minSize = $minSize;
    }

    /**
     * Validate
     * @param  File $file
     * @return bool
     */
    public function validate(File $file)
    {
        $fileSize = $file->getSize();
        $isValid = true;

        if ($fileSize < $this->minSize) {
            $this->setMessage('File size is too small');
            $isValid = false;
        }

        if ($fileSize > $this->maxSize) {
            $this->setMessage('File size is too large');
            $isValid = false;
        }

        return $isValid;
    }
}
