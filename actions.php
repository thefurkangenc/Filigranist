<?php
ini_set("memory_limit", -1);
include 'vendor/autoload.php';
use PHPImageWorkshop\ImageWorkshop;
$resultImages = [];
if (!empty($_FILES['watermark'])) {
    $extensionWatermark = substr($_FILES["watermark"]["name"], -4, 4);
    $nameWatermark = uniqid() . $extensionWatermark;
    $pathWatermark = "upload/watermarks/" . $nameWatermark;
    move_uploaded_file($_FILES["watermark"]["tmp_name"], $pathWatermark);
}
if (!empty($_FILES['image'])) {
    if (count($_FILES["image"]["tmp_name"]) > 0) {
        for ($i = 0; $i < count($_FILES["image"]["tmp_name"]); $i++) {
            $extension = substr($_FILES["image"]["name"][$i], -4, 4);
            $name = uniqid() . $extension;
            $path = "upload/images/" . $name;
            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $path);
            $image = ImageWorkshop::initFromPath('upload/images/' . $name);
            // Resmi yeniden boyutlandır.
            $thumbWidth = 80; // % 
            $thumbHeight = null;
            $conserveProportion = true; // En Boy orantısını koru
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $image->resizeInPercent($thumbWidth, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);

            $imageWidth = $image->getWidth();
            $imageHeight = $image->getHeight();
            $waterMarkLayer = ImageWorkshop::initFromPath('upload/watermarks/' . $nameWatermark);
            $waterMarkLayer->opacity(50);
            $waterMarkLayer->resizeInPixel($imageWidth / 2, null, true);
            $image->addLayerOnTop($waterMarkLayer, 0, 0, 'MM');

            // Son hali kaydet
            $dirPath = __DIR__ . "/upload/results/";
            $filename = $name;
            $createFolders = true; // Bahsi geçen klasörler yok ise oluştur
            $backgroundColor = null; // arkaplan rengi
            $imageQuality = 95; // 0 - 100
            $image->save($dirPath, $filename, $createFolders, $backgroundColor, $imageQuality);
            $resultPath = 'upload/results/' . $filename;
            array_push($resultImages , $resultPath);
        }
         echo json_encode($resultImages);
    }
}
