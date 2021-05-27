<?php


namespace App\Upload;


use App\Entity\Serie;

class SerieImage
{
    public function save($file, Serie $serie, $directory)
    {
        $newFileName = $serie->getName() . '-' . uniqid() . '.' . $file->guessExtension();
        $file->move($directory, $newFileName); // upload_poster_series_dir est définit dans services.yaml
        $serie->setPoster($newFileName); // on définit le poster dans l'objet série, avant de le pousser en BDD
    }

}