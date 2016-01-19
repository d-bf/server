<?php
namespace app\components;

use Yii;
use yii\helpers\FileHelper;

class AppComp extends \yii\base\Component
{

    /**
     *
     * @return string
     */
    public static function getStoragePath()
    {
        return Yii::$app->basePath . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR;
    }

    /**
     *
     * @return string
     */
    public static function getVendorPath()
    {
        return self::getStoragePath() . 'vendor' . DIRECTORY_SEPARATOR;
    }

    /**
     * Sends a file to user.
     *
     * @param string $fileName
     *            file name
     * @param string $filePath
     *            file path
     * @param string $mimeType
     *            mime type of the content. If null, it will be guessed automatically based on the given file name.
     * @param boolean $terminate
     *            whether to terminate the current application after calling this method
     */
    public static function sendFile($fileName, $filePath, $mimeType = null, $terminate = false)
    {
        $chunkSize = 1048576; // 1 MB
        
        if (empty($fileName))
            $fileName = basename($filePath);
        if ($mimeType === null) {
            if (($mimeType = FileHelper::getMimeTypeByExtension($fileName)) === null)
                $mimeType = 'application/octet-stream';
        }
        
        $fileSize = filesize($filePath);
        $contentStart = 0;
        $contentEnd = $fileSize - 1;
        
        if (isset($_SERVER['HTTP_RANGE'])) {
            header('Accept-Ranges: bytes');
            
            // client sent us a multibyte range, can not hold this one for now
            if (strpos($_SERVER['HTTP_RANGE'], ',') !== false) {
                header("Content-Range: bytes $contentStart-$contentEnd/$fileSize");
                throw new CHttpException(416, 'Requested Range Not Satisfiable');
            }
            
            $range = str_replace('bytes=', '', $_SERVER['HTTP_RANGE']);
            
            // range requests starts from "-", so it means that data must be dumped the end point.
            if ($range[0] === '-')
                $contentStart = $fileSize - substr($range, 1);
            else {
                $range = explode('-', $range);
                $contentStart = $range[0];
                
                // check if the last-byte-pos presents in header
                if ((isset($range[1]) && is_numeric($range[1])))
                    $contentEnd = $range[1];
            }
            
            /*
             * Check the range and make sure it's treated according to the specs.
             * http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
             */
            // End bytes can not be larger than $end.
            $contentEnd = ($contentEnd > $fileSize) ? $fileSize - 1 : $contentEnd;
            
            // Validate the requested range and return an error if it's not correct.
            $wrongContentStart = ($contentStart > $contentEnd || $contentStart > $fileSize - 1 || $contentStart < 0);
            
            if ($wrongContentStart) {
                header("Content-Range: bytes $contentStart-$contentEnd/$fileSize");
                throw new CHttpException(416, 'Requested Range Not Satisfiable');
            }
            
            header('HTTP/1.1 206 Partial Content');
            header("Content-Range: bytes $contentStart-$contentEnd/$fileSize");
        } else
            header('HTTP/1.1 200 OK');
        
        $length = $contentEnd - $contentStart + 1; // Calculate new content length
        
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Content-Type: $mimeType");
        header('Content-Length: ' . $length);
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Content-Transfer-Encoding: binary');
        
        if ($terminate) {
            // clean up the application first because the file downloading could take long time
            // which may cause timeout of some resources (such as DB connection)
            ob_start();
            \Yii::$app->end(0, false);
            ob_end_clean();
        }
        
        $fp = fopen($filePath, 'rb');
        fseek($fp, $contentStart);
        $size = min($chunkSize, $length);
        while ($size > 0) {
            $chunk = fread($fp, $size);
            echo $chunk;
            $length -= $size;
            $size = min($chunkSize, $length);
        }
        fclose($fp);
        
        if ($terminate)
            exit(0);
    }
}