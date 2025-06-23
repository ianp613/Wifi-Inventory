<?php
    class File{
        /**
         * ---------------------------------------------------------------------
         * Upload All File Types in custom directory within the framework
         * ---------------------------------------------------------------------
         */
        public static function upload_custom($data,$index,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir.basedir."".$folder) === false){
                mkdir(basedir.basedir."".$folder);
            }
            $destination = basedir.basedir."".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'];
            $size = $_FILES[$index]['size'];
            $tmp = $_FILES[$index]['tmp_name'];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $imageFile = array('png','jpg','jpeg','img','ico');
            $musicFile = array('mp3','wma','ape','ogg','fla','aac','m4a','ac3','wav','wv');
            $videoFile = array('mp4','avi','mkv','mov','mpeg','webm','3gp');
            $xlsxfile = array('xls','xlsx');
            $docxFile = array('doc','docx');
            $pptxFile = array('ppt','pptx');
            $pdfFile = array('pdf');
            $compressFile = array('zip','rar','bin','iso');

            if(in_array($ext_secondary, $imageFile)){
                $type = "IMAGE";
            }else if(in_array($ext_secondary, $musicFile)){
                $type = "SOUND";
            }else if(in_array($ext_secondary, $videoFile)){
                $type = "VIDEO";
            }else if(in_array($ext_secondary, $xlsxfile)){
                $type = "XLSX";
            }else if(in_array($ext_secondary, $docxFile)){
                $type = "DOCX";
            }else if(in_array($ext_secondary, $pptxFile)){
                $type = "PPTX";
            }else if(in_array($ext_secondary, $pdfFile)){
                $type = "PDF";
            }else if(in_array($ext_secondary, $compressFile)){
                $type = "ARCHIVE";
            }else{
                $type = "FILE";
            }

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            if($size < 40000000 /**to 40000000 */){
                $dest = $destination.$name_secondary;
                move_uploaded_file($tmp, $dest);
                $response->file = $name_secondary;
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = $type;
                $response->location = $destination;
                $response->status = true;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload All File Types
         * ---------------------------------------------------------------------
         */
        public static function upload_file($data,$index,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir.basedir."public/root/file/".$folder) === false){
                mkdir(basedir.basedir."public/root/file/".$folder);
            }
            $destination = basedir.basedir."public/root/file/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'];
            $size = $_FILES[$index]['size'];
            $tmp = $_FILES[$index]['tmp_name'];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $imageFile = array('png','jpg','jpeg','img','ico');
            $musicFile = array('mp3','wma','ape','ogg','fla','aac','m4a','ac3','wav','wv');
            $videoFile = array('mp4','avi','mkv','mov','mpeg','webm','3gp');
            $xlsxfile = array('xls','xlsx');
            $docxFile = array('doc','docx');
            $pptxFile = array('ppt','pptx');
            $pdfFile = array('pdf');
            $compressFile = array('zip','rar','bin','iso');

            if(in_array($ext_secondary, $imageFile)){
                $type = "IMAGE";
            }else if(in_array($ext_secondary, $musicFile)){
                $type = "SOUND";
            }else if(in_array($ext_secondary, $videoFile)){
                $type = "VIDEO";
            }else if(in_array($ext_secondary, $xlsxfile)){
                $type = "XLSX";
            }else if(in_array($ext_secondary, $docxFile)){
                $type = "DOCX";
            }else if(in_array($ext_secondary, $pptxFile)){
                $type = "PPTX";
            }else if(in_array($ext_secondary, $pdfFile)){
                $type = "PDF";
            }else if(in_array($ext_secondary, $compressFile)){
                $type = "ARCHIVE";
            }else{
                $type = "FILE";
            }

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            if($size < 40000000 /**to 40000000 */){
                $dest = $destination.$name_secondary;
                move_uploaded_file($tmp, $dest);
                $response->file = $name_secondary;
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = $type;
                $response->location = $destination;
                $response->status = true;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload All File Types Multiple
         * ---------------------------------------------------------------------
         */
        public static function upload_file_multiple($data,$index,$i,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir.basedir."public/root/file/".$folder) === false){
                mkdir(basedir."../public/root/file/".$folder);
            }
            $destination = basedir."../public/root/file/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'][$i];
            $size = $_FILES[$index]['size'][$i];
            $tmp = $_FILES[$index]['tmp_name'][$i];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $imageFile = array('png','jpg','jpeg','img','ico');
            $musicFile = array('mp3','wma','ape','ogg','fla','aac','m4a','ac3','wav','wv');
            $videoFile = array('mp4','avi','mkv','mov','mpeg','webm','3gp');
            $xlsxfile = array('xls','xlsx');
            $docxFile = array('doc','docx');
            $pptxFile = array('ppt','pptx');
            $pdfFile = array('pdf');
            $compressFile = array('zip','rar','bin','iso');

            if(in_array($ext_secondary, $imageFile)){
                $type = "IMAGE";
            }else if(in_array($ext_secondary, $musicFile)){
                $type = "SOUND";
            }else if(in_array($ext_secondary, $videoFile)){
                $type = "VIDEO";
            }else if(in_array($ext_secondary, $xlsxfile)){
                $type = "XLSX";
            }else if(in_array($ext_secondary, $docxFile)){
                $type = "DOCX";
            }else if(in_array($ext_secondary, $pptxFile)){
                $type = "PPTX";
            }else if(in_array($ext_secondary, $pdfFile)){
                $type = "PDF";
            }else if(in_array($ext_secondary, $compressFile)){
                $type = "ARCHIVE";
            }else{
                $type = "FILE";
            }

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            if($size < 40000000 /**to 40000000 */){
                $dest = $destination.$name_secondary;
                move_uploaded_file($tmp, $dest);
                $response->file = $name_secondary;
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = $type;
                $response->location = $destination;
                $response->status = true;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Image File Type
         * ---------------------------------------------------------------------
         */
        public static function upload_img($data,$index,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/img/".$folder) === false){
                mkdir(basedir."../public/root/img/".$folder);
            }
            $destination = basedir."../public/root/img/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'];
            $size = $_FILES[$index]['size'];
            $tmp = $_FILES[$index]['tmp_name'];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $imageFile = array('png','jpg','jpeg','img','ico');

            if(in_array($ext_secondary, $imageFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "IMAGE";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Image File Type Multiple
         * ---------------------------------------------------------------------
         */
        public static function upload_img_multiple($data,$index,$i,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/img/".$folder) === false){
                mkdir(basedir."../public/root/img/".$folder);
            }
            $destination = basedir."../public/root/img/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'][$i];
            $size = $_FILES[$index]['size'][$i];
            $tmp = $_FILES[$index]['tmp_name'][$i];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $imageFile = array('png','jpg','jpeg','img','ico');

            if(in_array($ext_secondary, $imageFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "IMAGE";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Document File Type
         * ---------------------------------------------------------------------
         */
        public static function upload_document($data,$index,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/document/".$folder) === false){
                mkdir(basedir."../public/root/document/".$folder);
            }
            $destination = basedir."../public/root/document/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'];
            $size = $_FILES[$index]['size'];
            $tmp = $_FILES[$index]['tmp_name'];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $xlsxfile = array('xls','xlsx');
            $docxFile = array('doc','docx');
            $pptxFile = array('ppt','pptx');
            $pdfFile = array('pdf');

            if(in_array($ext_secondary, $xlsxfile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "XLSX";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else if(in_array($ext_secondary, $docxFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "DOCX";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else if(in_array($ext_secondary, $pptxFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "PPTX";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else if(in_array($ext_secondary, $pdfFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "PDF";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Document File Type Multiple
         * ---------------------------------------------------------------------
         */
        public static function upload_document_multiple($data,$index,$i,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/document/".$folder) === false){
                mkdir(basedir."../public/root/document/".$folder);
            }
            $destination = basedir."../public/root/document/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'][$i];
            $size = $_FILES[$index]['size'][$i];
            $tmp = $_FILES[$index]['tmp_name'][$i];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $xlsxfile = array('xls','xlsx');
            $docxFile = array('doc','docx');
            $pptxFile = array('ppt','pptx');
            $pdfFile = array('pdf');

            if(in_array($ext_secondary, $xlsxfile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "XLSX";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else if(in_array($ext_secondary, $docxFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "DOCX";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else if(in_array($ext_secondary, $pptxFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "PPTX";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else if(in_array($ext_secondary, $pdfFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "PDF";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Sound File Type
         * ---------------------------------------------------------------------
         */
        public static function upload_sound($data,$index,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/sound/".$folder) === false){
                mkdir(basedir."../public/root/sound/".$folder);
            }
            $destination = basedir."../public/root/sound/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'];
            $size = $_FILES[$index]['size'];
            $tmp = $_FILES[$index]['tmp_name'];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $musicFile = array('mp3','wma','ape','ogg','fla','aac','m4a','ac3','wav','wv');

            if(in_array($ext_secondary, $musicFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "SOUND";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Sound File Type Multiple
         * ---------------------------------------------------------------------
         */
        public static function upload_sound_multiple($data,$index,$i,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/sound/".$folder) === false){
                mkdir(basedir."../public/root/sound/".$folder);
            }
            $destination = basedir."../public/root/sound/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'][$i];
            $size = $_FILES[$index]['size'][$i];
            $tmp = $_FILES[$index]['tmp_name'][$i];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $musicFile = array('mp3','wma','ape','ogg','fla','aac','m4a','ac3','wav','wv');

            if(in_array($ext_secondary, $musicFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "SOUND";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Video File Type
         * ---------------------------------------------------------------------
         */
        public static function upload_video($data,$index,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/video/".$folder) === false){
                mkdir(basedir."../public/root/video/".$folder);
            }
            $destination = basedir."../public/root/video/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'];
            $size = $_FILES[$index]['size'];
            $tmp = $_FILES[$index]['tmp_name'];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $videoFile = array('mp4','avi','mkv','mov','mpeg','webm','3gp');

            if(in_array($ext_secondary, $videoFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "VIDEO";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Video File Type Multiple
         * ---------------------------------------------------------------------
         */
        public static function upload_video_multiple($data,$index,$i,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/video/".$folder) === false){
                mkdir(basedir."../public/root/video/".$folder);
            }
            $destination = basedir."../public/root/video/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'][$i];
            $size = $_FILES[$index]['size'][$i];
            $tmp = $_FILES[$index]['tmp_name'][$i];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $videoFile = array('mp4','avi','mkv','mov','mpeg','webm','3gp');

            if(in_array($ext_secondary, $videoFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "VIDEO";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Archive File Type
         * ---------------------------------------------------------------------
         */
        public static function upload_archive($data,$index,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/archive/".$folder) === false){
                mkdir(basedir."../public/root/archive/".$folder);
            }
            $destination = basedir."../public/root/archive/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'];
            $size = $_FILES[$index]['size'];
            $tmp = $_FILES[$index]['tmp_name'];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $compressFile = array('zip','rar','bin','iso');

            if(in_array($ext_secondary, $compressFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "ARCHIVE";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Upload Archive File Type Multiple
         * ---------------------------------------------------------------------
         */
        public static function upload_archive_multiple($data,$index,$i,$folder){
            $response = new Response;
            $response->file = "";
            $response->name = "";
            $response->size = "";
            $response->type = "";
            $response->location = "";
            $response->status = false;
            if(is_dir(basedir."../public/root/archive/".$folder) === false){
                mkdir(basedir."../public/root/archive/".$folder);
            }
            $destination = basedir."../public/root/archive/".$folder."/";
            $file = $data[$index];

            $name_primary = $_FILES[$index]['name'][$i];
            $size = $_FILES[$index]['size'][$i];
            $tmp = $_FILES[$index]['tmp_name'][$i];

            $ext_primary = explode('.', $name_primary);
            $ext_secondary = strtolower(end($ext_primary));
        
            $name_secondary = uniqid('', true);
            $name_secondary = $name_secondary.".".$ext_secondary;

            $arraycount = count($ext_primary);
            $nametemp = "";
            if($arraycount > 2){
                $i = 0;
                while($i < $arraycount-1){
                    if($nametemp == ""){
                        $nametemp = $ext_primary[$i];
                    }else{
                        $nametemp = $nametemp.'.'.$ext_primary[$i];
                    }
                    $i++;
                }
            }else{
                $nametemp = $ext_primary[0];
            }

            $compressFile = array('zip','rar','bin','iso');

            if(in_array($ext_secondary, $compressFile)){
                if($size < 40000000 /**to 40000000 */){
                    $dest = $destination.$name_secondary;
                    move_uploaded_file($tmp, $dest);
                    $response->file = $name_secondary;
                    $response->name = $nametemp.'.'.$ext_secondary;
                    $response->size = $size;
                    $response->type = "ARCHIVE";
                    $response->location = $destination;
                    $response->status = true;
                }
            }else{
                $response->file = "";
                $response->name = $nametemp.'.'.$ext_secondary;
                $response->size = $size;
                $response->type = "INVALID";
                $response->location = "";
                $response->status = false;
            }
            return $response;
        }
        /**
         * ---------------------------------------------------------------------
         * Download All File Types
         * ---------------------------------------------------------------------
         */
        public static function download_file($file,$name,$folder){
            $folder = basedir."".$folder;
            header("location: ../../unite/file handler/file.download.php?type=File&file=$file&name=$name&folder=$folder");
        } 
        public static function download_img($file,$name,$folder){
            $folder = basedir."".$folder;
            header("location: ../../unite/file handler/file.download.php?type=Img&file=$file&name=$name&folder=$folder");
        }
        public static function download_document($file,$name,$folder){
            $folder = basedir."".$folder;
            header("location: ../../unite/file handler/file.download.php?type=Document&file=$file&name=$name&folder=$folder");
        } 
        public static function download_sound($file,$name,$folder){
            $folder = basedir."".$folder;
            header("location: ../../unite/file handler/file.download.php?type=Sound&file=$file&name=$name&folder=$folder");
        }
        public static function download_video($file,$name,$folder){
            $folder = basedir."".$folder;
            header("location: ../../unite/file handler/file.download.php?type=Video&file=$file&name=$name&folder=$folder");
        }
        public static function download_archive($file,$name,$folder){
            $folder = basedir."".$folder;
            header("location: ../../unite/file handler/file.download.php?type=Archive&file=$file&name=$name&folder=$folder");
        }
        public static function download_qr($file,$name){
            header("location: ../../unite/file handler/qr.download.php?file=$file&name=$name");
        }
        public static function download_log(){
            header("location: ../../unite/file handler/log.download.php");
        }
        /**
         * ---------------------------------------------------------------------
         * Delete All File Types
         * ---------------------------------------------------------------------
         */
        public static function delete($file,$folder){
            if(file_exists($folder.$file)){
                unlink($folder.$file);
                return true;
            }else{
                return false;
            }
        }
    }
    class Response{
        public $response = [];
    }
?>