<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\Storage\Base;
use Itxiao6\Upload\Exception\UploadException;
use Itxiao6\Upload\File;
use InvalidArgumentException;
/**
 * 本地文件存储
 * Class FileSystem
 * @package Itxiao6\Upload\Storage
 */
class FileSystem extends Base
{
    /**
     * web访问目录
     * @var string
     */
    protected $host;
    /**
     * web可以访问的url
     * @var
     */
    protected $webUrl;
    /**
     * Upload directory
     * @var string
     */
    protected $directory;

    /**
     * Overwrite existing files?
     * @var bool
     */
    protected $overwrite;

    /**
     * Constructor
     * @param  string                       $directory      Relative or absolute path to upload directory
     * @param  string                       $host      Should this overwrite existing files?
     * @param  bool                         $overwrite      Should this overwrite existing files?
     * @throws InvalidArgumentException                    If directory does not exist
     * @throws InvalidArgumentException                    If directory is not writable
     */
    public function __construct($directory,$host, $overwrite = false)
    {
        if (!is_dir($directory)) {
            throw new InvalidArgumentException('Directory does not exist');
        }
        if (!is_writable($directory)) {
            throw new InvalidArgumentException('Directory is not writable');
        }
        $this->directory = rtrim($directory, '/') . DIRECTORY_SEPARATOR;
        $this->overwrite = $overwrite;
        $this -> host = $host;
    }

    /**
     * Upload
     * @param  File $file The file object to upload
     * @param  string $newName Give the file it a new name
     * @return bool
     * @throws \RuntimeException   If overwrite is false and file already exists
     */
    public function upload(File $file, $newName = null)
    {
        if (is_string($newName)) {
            $fileName = strpos($newName, '.') ? $newName : $newName.'.'.$file->getExtension();

        } else {
            $fileName = $file->getNameWithExtension();
        }

        $newFile = $this->directory . $fileName;
        if ($this->overwrite === false && file_exists($newFile)) {
            $file->addError('File already exists');
            throw new UploadException('File already exists');
        }
        # 设置web访问目录
        $this -> webUrl = rtrim($this -> host,'/').'/'.(isset($newName)||$newName==''?
                $file -> getName().'.'.$file->getExtension()
                :$newName
            );
        # 返回上传结果
        return $this->moveUploadedFile($file->getPathname(), $newFile);
    }

    /**
     * 获取WebUrl
     * @return mixed
     */
    public function getWebUrl(){
        return $this -> webUrl;
    }

    /**
     * Move uploaded file
     *
     * This method allows us to stub this method in unit tests to avoid
     * hard dependency on the `move_uploaded_file` function.
     *
     * @param  string $source      The source file
     * @param  string $destination The destination file
     * @return bool
     */
    protected function moveUploadedFile($source, $destination)
    {
        return copy($source,$destination);
    }
}
