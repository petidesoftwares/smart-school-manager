<?php
if(isset($_POST)){
    $image_file= $_POST['image'];
    $filePath = "../pupil-album/";

    //split file into parts
    $file_parts = explode(";base64,",$image_file);

    //Get the image type (extension)
    $file_type_arr = explode("image/",$file_parts[0]);
    $file_type = $file_type_arr[1];

    //Decode the image in base64
    $file_base64 = base64_decode($file_parts[1]);

    //Name the image
    $file_name = uniqid().".png";

    $file = $filePath.$file_name;

    //write to file
    file_put_contents($file, $file_base64);

    echo $file_name;

}
