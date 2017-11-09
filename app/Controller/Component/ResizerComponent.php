<?php

class ResizerComponent extends Component
{
    /**
     * 	Private Vars
     */
    public $_file;
    public $_filepath;
    public $_destination;
    public $_name;
    public $_short;
    public $_rules;
    public $_allowed;

    /**
     * 	Public Vars
     */
    public $errors;
    public function load($filename) {

      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if($this->image_type == IMAGETYPE_JPEG) {

         $this->image = imagecreatefromjpeg($filename);
      } elseif($this->image_type == IMAGETYPE_GIF) {

         $this->image = imagecreatefromgif($filename);
      } elseif($this->image_type == IMAGETYPE_PNG) {

         $this->image = imagecreatefrompng($filename);
      }
   }
   public function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }
    public function startup(Controller $controller)
    {
        // This method takes a reference to the controller which is loading it.
        // Perform controller initialization here.
    }

    /**
     * upload
     * - handle uploads of any type
     *
     * 		@ file - a file (file to upload) $_FILES[FILE_NAME]
     * 		@ path - string (where to upload to)
     * 		@ name [optional] - override saved filename
     * 		@ rules [optional] - how to handle file types
     * 			- rules['type'] = string ('resize','resizemin','resizecrop','crop')
     * 			- rules['size'] = array (x, y) or single number
     * 			- rules['output'] = string ('gif','png','jpg')
     * 			- rules['quality'] = integer (quality of output image)
     * 		@ allowed [optional] - allowed filetypes
     * 			- defaults to 'jpg','jpeg','gif','png'
     * 	ex:
     * 	$upload = new upload($_FILES['MyFile'], 'uploads');
     *
     * @param mixed      $file
     * @param mixed      $destination
     * @param null|mixed $name
     * @param null|mixed $rules
     * @param null|mixed $allowed
     */
    public function upload($file, $destination, $name = NULL, $rules = NULL, $allowed = NULL)
    {

        $this->result = false;
        $this->error = false;

        // -- save parameters
        $this->_file = $file;
        $this->_destination = $destination;
        if (!is_null($rules))
            $this->_rules = $rules;

        if (!is_null($allowed))
        {
            $this->_allowed = $allowed;
        } else
        {
            $this->_allowed = ['jpg', 'jpeg', 'gif', 'png', 'JPG', 'PNG'];
        }

        // -- hack dir if / not provided
        if (substr($this->_destination, -1) != '/')
        {
            $this->_destination .= '/';
        }

        // -- check that FILE array is even set
        if (isset($file) && is_array($file) && !$this->upload_error($file['error']))
        {

            // -- cool, now set some variables
            //$fileName = ($name == NULL) ? $this->uniquename($destination . $file['name']) : $destination . $name;
            $fileName = ($name == NULL) ? $this->uniquename($destination . $file['name']) : $destination . $name;
            $inputFileName = $destination . $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];
            $fileError = $file['error'];
            //pr($fileTmp." ".$fileSize." ".$fileType);die;
            // -- update name
            $this->_name = $fileName;

            // -- error if not correct extension
            if (!in_array($this->ext($inputFileName), $this->_allowed))
            {

                $this->error('File type not allowed.');
            } else
            {

                //echo $fileTmp;die;
                // -- it's been uploaded with php
                if (is_uploaded_file($fileTmp))
                {

                    // -- how are we handling this file
                    if ($rules == NULL)
                    {
                        // -- where to put the file?
                        $output = $fileName;
                        // -- just upload it.

                        if (copy($fileTmp, $output))
                        {

                            chmod($output, 0755);
                            $this->result = basename($this->_name);
                        } else
                        {
                            $this->error("Could not move '$fileName' to '$destination'");
                        }
                    } else
                    {
                        // -- gd lib check
                        if (function_exists('imagecreatefromjpeg'))
                        {
                            if (!isset($rules['output']))
                                $rules['output'] = NULL;
                            if (!isset($rules['quality']))
                                $rules['quality'] = NULL;
                            // -- handle it based on rules
                            if (isset($rules['type']) && isset($rules['size']))
                            {
                                $this->image($this->_file, $rules['type'], $rules['size'], $rules['output'], $rules['quality']);
                            } else
                            {
                                $this->error('Invalid "rules" parameter');
                            }
                        } else
                        {
                            $this->error('GD library is not installed');
                        }
                    }
                } else
                {
                    $this->error("Possible file upload attack on '$fileName'");
                }
            }
        } else
        {
            $this->error('Possible file upload attack');
        }
        return $this->result;
    }

    // -- return the extension of a file
    public function ext($file)
    {
        $ext = trim(substr($file, strrpos($file, '.') + 1, strlen($file)));
        return $ext;
    }

    // -- add a message to stack (for outside checking)
    public function error($message)
    {
        if (!is_array($this->errors))
            $this->errors = [];
        array_push($this->errors, $message);
    }

    public function image($file, $type, $size, $output = NULL, $quality = NULL,$height=NULL)
    {

       // echo $file;
        if (is_null($type))
            $type = 'resize';
        if (is_null($size))
            $size = 100;
        if (is_null($output))
            $output = 'jpg';
        if (is_null($quality))
            $quality = 75;

        // -- format variables
        $type = strtolower($type);
        $output = strtolower($output);
        if (is_array($size))
        {
            $maxW = intval($size[0]);
            $maxH = intval($size[1]);
        } else
        {
            $maxScale = intval($size);
        }

        // -- check sizes
        if (isset($maxScale))
        {
            if (!$maxScale)
            {
                $this->error('Max scale must be set');
            }
        } else
        {
            if (!$maxW || !$maxH)
            {
                $this->error('Size width and height must be set');
                return;
            }
            if ($type == 'resize')
            {
                $this->error('Provide only one number for size');
            }
        }

        // -- check output
        if ($output != 'jpg' && $output != 'png' && $output != 'gif')
        {
            $this->error('Cannot output file as ' . strtoupper($output));
        }

        if (is_numeric($quality))
        {
            $quality = intval($quality);
            if ($quality > 100 || $quality < 1)
            {
                $quality = 75;
            }
        } else
        {
            $quality = 75;
        }

        // -- get some information about the file
        $uploadSize = getimagesize($file['tmp_name']);
        $uploadWidth = $uploadSize[0];
        $uploadHeight = $uploadSize[1];
        $uploadType = $uploadSize[2];

        if ($uploadType != 1 && $uploadType != 2 && $uploadType != 3)
        {
            $this->error('File type must be GIF, PNG, or JPG to resize');
        }

        switch ($uploadType)
        {
            case 1: $srcImg = imagecreatefromgif($file['tmp_name']);
                break;
            case 2: $srcImg = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 3: $srcImg = imagecreatefrompng($file['tmp_name']);
                break;
            default: $this->error('File type must be GIF, PNG, or JPG to resize');
        }

        switch ($type)
        {

            case 'resize':
                # Maintains the aspect ration of the image and makes sure that it fits
                # within the maxW and maxH (thus some side will be smaller)
                // -- determine new size
                if (isset($maxScale))
                {
                  #echo $uploadWidth."sda".$maxScale."adsa".$uploadHeight;
                    if ($uploadWidth > $maxScale || $uploadHeight > $maxScale)
                    {
                        if ($uploadWidth > $uploadHeight)
                        {
                            $newX = $maxScale;
                            $newY = ($uploadHeight * $newX) / $uploadWidth;
                        } else if ($uploadWidth < $uploadHeight)
                        {
                            $newY = $maxScale;
                            $newX = ($newY * $uploadWidth) / $uploadHeight;
                        } else if ($uploadWidth == $uploadHeight)
                        {
                            $newX = $newY = $maxScale;
                        }
                    } else
                    {
                        $newX = $uploadWidth;
                        $newY = $uploadHeight;
                    }
                } else
                {
                    $newX = $maxW;
                    $newY = $maxH;
                }
                if($height != '' || $height != NULL){
                  $newY = $height;
                }
               # echo $newY; die;
                $dstImg = imagecreatetruecolor($newX, $newY);
                imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newX, $newY, $uploadWidth, $uploadHeight);

                break;

            case 'resizemin':
                # Maintains aspect ratio but resizes the image so that once
                # one side meets its maxW or maxH condition, it stays at that size
                # (thus one side will be larger)
                #get ratios
                $ratioX = $maxW / $uploadWidth;
                $ratioY = $maxH / $uploadHeight;

                #figure out new dimensions
                if (($uploadWidth == $maxW) && ($uploadHeight == $maxH))
                {
                    $newX = $uploadWidth;
                    $newY = $uploadHeight;
                } else if (($ratioX * $uploadHeight) > $maxH)
                {
                    $newX = $maxW;
                    $newY = ceil($ratioX * $uploadHeight);
                } else
                {
                    $newX = ceil($ratioY * $uploadWidth);
                    $newY = $maxH;
                }

                $dstImg = imagecreatetruecolor($newX, $newY);
                imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newX, $newY, $uploadWidth, $uploadHeight);

                break;

            case 'resizecrop':
                // -- resize to max, then crop to center
                $ratioX = $maxW / $uploadWidth;
                $ratioY = $maxH / $uploadHeight;

                if ($ratioX < $ratioY)
                {
                    $newX = round(($uploadWidth - ($maxW / $ratioY)) / 2);
                    $newY = 0;
                    $uploadWidth = round($maxW / $ratioY);
                    $uploadHeight = $uploadHeight;
                } else
                {
                    $newX = 0;
                    $newY = round(($uploadHeight - ($maxH / $ratioX)) / 2);
                    $uploadWidth = $uploadWidth;
                    $uploadHeight = round($maxH / $ratioX);
                }

                $dstImg = imagecreatetruecolor($maxW, $maxH);
                imagecopyresampled($dstImg, $srcImg, 0, 0, $newX, $newY, $maxW, $maxH, $uploadWidth, $uploadHeight);

                break;

            case 'crop':
                // -- a straight centered crop
                $startY = ($uploadHeight - $maxH) / 2;
                $startX = ($uploadWidth - $maxW) / 2;

                $dstImg = imageCreateTrueColor($maxW, $maxH);
                ImageCopyResampled($dstImg, $srcImg, 0, 0, $startX, $startY, $maxW, $maxH, $maxW, $maxH);

                break;

            default: $this->error("Resize function \"$type\" does not exist");
        }

        // -- try to write
        switch ($output)
        {
            case 'jpg':
                $write = imagejpeg($dstImg, $this->_name, $quality);
                break;
            case 'png':
                $write = imagepng($dstImg, $this->_name . '.png', $quality);
                break;
            case 'gif':
                $write = imagegif($dstImg, $this->_name . '.gif', $quality);
                break;
        }

        // -- clean up
        imagedestroy($dstImg);

        if ($write)
        {
            $this->result = basename($this->_name);
        } else
        {
            $this->error('Could not write ' . $this->_name . ' to ' . $this->_destination);
        }
    }

    public function newname($file)
    {
        return time() . '.' . $this->ext($file);
    }

    public function uniquename($file)
    {
        $parts = pathinfo($file);
        $dir = $parts['dirname'];
        $file = ereg_replace('[^[:alnum:]_.-]', '', $parts['basename']);
        $ext = $parts['extension'];
        if ($ext)
        {
            $ext = '.' . $ext;
            $file = substr($file, 0, -strlen($ext));
        }
        $i = 0;
        while (file_exists($dir . '/' . $file . $i . $ext))
            $i++;
        return $dir . '/' . $file . $i . $ext;
    }

     public function getWidth() {

      return imagesx($this->image);
   }
   public function getHeight() {

      return imagesy($this->image);
   }
    public function upload_error($errorobj)
    {
        $error = false;
        switch ($errorobj)
        {
            case UPLOAD_ERR_OK: break;
            case UPLOAD_ERR_INI_SIZE: $error = 'The uploaded file exceeds the upload_max_filesize directive (' . ini_get('upload_max_filesize') . ') in php.ini.';
                break;
            case UPLOAD_ERR_FORM_SIZE: $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                break;
            case UPLOAD_ERR_PARTIAL: $error = 'The uploaded file was only partially uploaded.';
                break;
            case UPLOAD_ERR_NO_FILE: $error = 'No file was uploaded.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR: $error = 'Missing a temporary folder.';
                break;
            case UPLOAD_ERR_CANT_WRITE: $error = 'Failed to write file to disk';
                break;
            default: $error = 'Unknown File Error';
        }
        return $error;
    }
public function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
       if($image_type == IMAGETYPE_JPEG) {
         imagejpeg($this->image,$filename,$compression);
      } elseif($image_type == IMAGETYPE_GIF) {

         imagegif($this->image,$filename);
      } elseif($image_type == IMAGETYPE_PNG) {

         imagepng($this->image,$filename);
      }
      if($permissions != null) {

         chmod($filename,$permissions);
      }
   }

   public function getResize($height, $width, $newHeight, $newWidth, $filenamePass, $uploadPath){

      $extension = $this->getExtension($uploadPath);
      $extension = strtolower($extension);

      //Scale To Ratio
    //   if($width >= $height){
    //	  $newWidth = $new_dimension_pass;
    //	  $newHeight = ($height/$width)*$new_dimension_pass;
    //   }
    //   else{
    //	  $newHeight = $new_dimension_pass;
    //	  $newWidth = ($width/$height)*$new_dimension_pass;
    //   }

      $imagePas = imagecreatetruecolor($newWidth, $newHeight);
      if($extension=='jpg' || $extension=='jpeg'){
          $image = imagecreatefromjpeg($filenamePass);
          imagecopyresampled($imagePas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
          imagejpeg($imagePas,$uploadPath ,100);
          return 1;
      } else if($extension=='png'){
                    $image = imagecreatefrompng($filenamePass);
          //imagecopyresampled($imagePas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
          //imagepng($imagePas,$uploadPath ,9);

                    imagealphablending($imagePas, false);
                    imagesavealpha($imagePas,true);
                    $transparent = imagecolorallocatealpha($imagePas, 255, 255, 255, 127);
                    imagefilledrectangle($imagePas, 0, 0, $newWidth, $newHeight, $transparent);
                    imagecopyresampled($imagePas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    imagepng($imagePas, $uploadPath);
                    imagedestroy($imagePas);
                    imagedestroy($image);
                    return 1;
      }
          $image = imagecreatefromgif($filenamePass);
          imagecopyresampled($imagePas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
          imagegif($imagePas,$uploadPath);
          return 1;

      return 0;
     }

     public function getExtension($strPass){
      $ioata = strrpos($strPass,'.');
      if (!$ioata) { return ''; }
      $lens   = strlen($strPass) - $ioata;
      $exten = substr($strPass,$ioata+1,$lens);
      return $exten;
     }
}