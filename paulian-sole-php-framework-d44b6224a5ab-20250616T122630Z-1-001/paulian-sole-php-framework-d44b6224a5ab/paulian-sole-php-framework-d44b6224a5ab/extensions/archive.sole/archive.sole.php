<?php
    class Archive{
        /**
         * Class Archive
         *
         * Extract a archive (zip/gzip/rar) file.
         * 
         * @author ian
         * @param $archive
         * @param $destination
         * 
         */
        public static function extract($archive, $destination){
            $ext = pathinfo($archive, PATHINFO_EXTENSION);
            switch ($ext){
                case 'zip':
                    $res = self::extractZipArchive($archive, $destination);
                    return $res;
                    break;
                case 'gz':
                    $res = self::extractGzipFile($archive, $destination);
                    return $res;
                    break;
                case 'rar':
                    $res = self::extractRarArchive($archive, $destination);
                    return $res;
                    break;
                default:
                    return [false,'Invalid archive file.'];
                    break;
            }
        }
        /**
         * Decompress/extract a zip archive using ZipArchive.
         *
         * @param $archive
         * @param $destination
         */
        public static function extractZipArchive($archive, $destination){
            if(!class_exists('ZipArchive')){
                return [false,'Your PHP version doesn\'t have ZipArchive support.'];
            }
            if(file_exists($archive)){
                if(file_exists($destination)){
                    $zip = new ZipArchive;
                    if($zip->open($archive) === TRUE){
                        if(is_writeable($destination . '/')){
                            $zip->extractTo($destination);
                            $zip->close();
                            return [true,'Files extracted successfully.'];
                        }else{
                            return [false,'Directory not writeable by webserver.'];
                        }
                    }else{
                        return [false,'Cannot read .zip archive.'];
                    }    
                }else{
                    return [false,'Destination Folder doesn\'t exist.'];
                }
            }else{
                return [false,'File doesn\'t exist.'];
            }
            
        }

        /**
         * Decompress a .gz File.
         *
         * @param $archive
         * @param $destination
         */
        public static function extractGzipFile($archive, $destination){
            if(!function_exists('gzopen')){
                return [false,'Your PHP version doesn\'t have zlib support.'];
            }else{
                if(file_exists($archive)){
                    if(file_exists($destination)){
                        $filename = pathinfo($archive, PATHINFO_FILENAME);
                        $gzipped = gzopen($archive, "rb");
                        $file = fopen($filename, "w");
                        while ($string = gzread($gzipped, 4096)) {
                            fwrite($file, $string, strlen($string));
                        }
                        gzclose($gzipped);
                        fclose($file);
                        if(file_exists($destination.'/'.$filename)){
                            return [true,'Files extracted successfully.'];
                        }else{
                            return [false,'Cannot read .gz archive.'];
                        }    
                    }else{
                        return [false,'Destination Folder doesn\'t exist.'];
                    }
                }else{
                    return [false,'File doesn\'t exist.'];
                }   
            }
        }

        /**
         * Decompress/extract a Rar archive using RarArchive.
         *
         * @param $archive
         * @param $destination
         */
        public static function extractRarArchive($archive, $destination){
            if(!class_exists('RarArchive')){
                return [false,'Your PHP version doesn\'t have RarArchive support.'];
            }
            if(file_exists($archive)){
                if(file_exists($destination)){
                    if($rar = RarArchive::open($archive)){
                        if (is_writeable($destination . '/')) {
                            $entries = $rar->getEntries();
                            foreach ($entries as $entry) {
                                $entry->extract($destination);
                            }
                            $rar->close();
                            return [true,'Files extracted successfully.'];
                        }else{
                            return [false,'Directory not writeable by webserver.'];
                        }
                    }else{
                        return [false,'Cannot read .rar archive.'];
                    }        
                }else{
                    return [false,'Destination Folder doesn\'t exist.'];
                }
            }else{
                return [false,'File doesn\'t exist.'];
            }
            
        }
    }
?>