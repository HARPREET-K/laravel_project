<?php

namespace App\Classes;

use GeoIP;

class Common {

    public function getLocalOffsetValue() {
      try{
         $location = GeoIP::getLocation();
         $this_tz = new \DateTimeZone($location['timezone']);
         $now = new \DateTime("now", $this_tz);
         $offset = $this_tz->getOffset($now);
         \Log::info('time_zone : '.$location['timezone'].', offset : '.$offset);
                return $offset;
            }catch(\Exception $e){
                \Log::info('Exception:- time_zone : null, offset : -25200');
                return -25200; //return default denver offset
            }
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function createThumbnail($s3file, $extension, $originalImage) {
        $width = imagesx($originalImage);
        $height = imagesy($originalImage);
        if($width > $height){
          $base = $height;
          }else{
          $base = $width;
          }

        $base = $width;
        $new_height = 600;
        if ($base < $new_height) {
            $new_height = $width;
        }
        $calculationFactor = $base / $new_height;
        //$new_width = $width/$calculationFactor;
        $new_width = $new_height;
        $new_height = $height / $calculationFactor;
        //Added fixed witdth and height to manage metirial desing
      //  $new_width = 300;
      //  $new_height = 300;
        $imageResized = imagecreatetruecolor($new_width, $new_height);
        if (strtolower($extension) == "png") {
            imagealphablending($imageResized, false);
            imagesavealpha($imageResized, true);
            $transparent = imagecolorallocatealpha($imageResized, 255, 255, 255, 127);
            imagefilledrectangle($imageResized, 0, 0, $new_width, $new_height, $transparent);
        }
        imagecopyresampled($imageResized, $originalImage, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        $tempfilename = tempnam(__DIR__, "newImage");
        if (strtolower($extension) == "jpeg" || strtolower($extension) == "jpg") {
            imagejpeg($imageResized, $tempfilename, $new_height);
        } elseif (strtolower($extension) == "png") {
            imagepng($imageResized, $tempfilename, 9);
        }
        return $tempfilename;
    }

    public static function imagecreatefromfile($file_name, $file_extension) {



        switch (strtolower($file_extension)) {
            case 'jpeg':
                return imagecreatefromstring(file_get_contents($file_name));
                break;
            case 'jpg':
                return imagecreatefromstring(file_get_contents($file_name));
                break;
            case 'png':
                return imagecreatefromstring(file_get_contents($file_name));
                break;
            case 'gif':
                return imagecreatefromstring(file_get_contents($file_name));
                break;
            default:
                throw new InvalidArgumentException('File "' . $file_name . '" is not valid jpg, png or gif image.');
                break;
        }
    }

    public function post_value_or($key, $default = Null) {
        return isset($_POST[$key]) && !empty($_POST[$key]) ? $_POST[$key] : $default;
    }

    // New functions

    public function unpad($value) {
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        //apply pkcs7 padding removal
        $packing = ord($value[strlen($value) - 1]);
        if ($packing && $packing < $blockSize) {
            for ($P = strlen($value) - 1; $P >= strlen($value) - $packing; $P--) {
                if (ord($value{$P}) != $packing) {
                    $packing = 0;
                }//end if
            }//end for
        }//end if
        return substr($value, 0, strlen($value) - $packing);
    }

    function decryptRJ256($key, $iv, $string_to_decrypt) {
        $string_to_decrypt = base64_decode($string_to_decrypt);
        $rtn = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $string_to_decrypt, MCRYPT_MODE_CBC, $iv);
        //$rtn = rtrim($rtn, "\0\4");
        $rtn = $this->unpad($rtn);
        return($rtn);
    }

    function encryptRJ256($key, $iv, $string_to_encrypt) {
        $rtn = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string_to_encrypt, MCRYPT_MODE_CBC, $iv);
        $rtn = base64_encode($rtn);
        return($rtn);
    }

// function to get  the address
function get_lat_long($address) {
   $array = array();
   $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');

   // We convert the JSON to an array
   $geo = json_decode($geo, true);

   // If everything is cool
   if ($geo['status'] = 'OK') {
      $latitude = $geo['results'][0]['geometry']['location']['lat'];
      $longitude = $geo['results'][0]['geometry']['location']['lng'];
      $array = array('lat'=> $latitude ,'lng'=>$longitude);
   }

   return $array;
}
}
