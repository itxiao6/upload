<?php
namespace Itxiao6\Upload\Validation;
use Itxiao6\Upload\File;
/**
 * 验证接口
 * Class Base
 * @package Upload\Validation
 */
abstract class Base
{
    /**
     * The error message for this validation
     * @var string
     */
    protected $message;

    /**
     * Set error message
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get error message
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Validate file
     * @param  File $file
     * @return bool         True if file is valid, false if file is not valid
     */
    abstract public function validate(File $file);
}
