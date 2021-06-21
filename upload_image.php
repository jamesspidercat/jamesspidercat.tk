<?php

if(isset($_FILES['file']['name'])){

   /* Getting file name */
   $filename = $_FILES['file']['name'];

   /* Location */
   $location = "blog/".$_GET['id']."/".$filename;
   $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
   $imageFileType = strtolower($imageFileType);

   /* Valid extensions */
   $valid_extensions = array();
   switch ($_GET['type']){
      case "image":
         $valid_extensions = array("jpeg", "jpg", "gif", "png", "webp");
         break;
      case "video":
         $valid_extensions = array("mp4", "webm");
         break;
      case "audio":
         $valid_extensions = array("mp3", "wav");
   }

   $response = 0;
   /* Check file extension */
   if(in_array(strtolower($imageFileType), $valid_extensions)) {
      /* Upload file */
      if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
         $response = $location;
      }
   }

   echo $response;
   exit;
}
echo 0;