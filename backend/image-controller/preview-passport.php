<?php
//session_start();

    include_once ("../../vendor/autoload.php");
    include_once ("ImageManipulator.php");

    $file= $_FILES['tempPassport']['name'];
    /**Rename file */
    $fileExt = explode("/",$_FILES['tempPassport']['type']);
    $newName = uniqid().".".$fileExt[1];
    /**Change file extension */
    $formatedName = replace_extension($newName, "png");

    //$location = "a-profile-images/".$formatedName;
    $previewLocation = "../../statics/images/image-preview/".$formatedName;
    $uploadOk = 1;
    //$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
    $imageFileTypePreview = pathinfo($previewLocation,PATHINFO_EXTENSION);

    $valid_extensions = array("jpg","jpeg","png");
    /* Check file extension */
    if( !in_array(strtolower($imageFileTypePreview),$valid_extensions) ) {
        $uploadOk = 0;
    }

    if($uploadOk == 0){
        echo "ERROR!: Image format not supported.";
    }else{
        /* Upload file */
        if(move_uploaded_file($_FILES['tempPassport']['tmp_name'],$previewLocation)){
            $manipulateImage = new ImageManipulator($previewLocation);
            $newImage = $manipulateImage->resample(240,240,true);
            $manipulateImage->save($previewLocation);
            echo ($previewLocation);
        }else{
            echo "ERROR! Unable to load file";
        }
    }

    function replace_extension($filename, $new_extension) {
        $info = pathinfo($filename);
        return $info['filename'] . '.' . $new_extension;
    }
?>