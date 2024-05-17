<?php

// Register autoloader
require_once(FCPATH.'vendor/gasparesganga/php-shapefile/src/Shapefile/ShapefileAutoloader.php');
Shapefile\ShapefileAutoloader::register();

// Import classes
use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Shapefile\ShapefileWriter;
use Shapefile\Geometry\Point;
use Shapefile\Geometry\Geometry;
use PhpShapeFile\ShapeType;

// API Docs https://gasparesganga.com/labs/php-shapefile/

class M_ShapeFile extends CI_Model
{
    public function initFromGeoJSON(){
        // $geojson = '{"type":"Feature","geometry":{"type":"Polygon","coordinates":[[[-74.0,40.7],[-74.0,40.8],[-73.9,40.8],[-73.9,40.7],[-74.0,40.7]]]},"properties":{}}';
        // $geo = new Geometry();
        // $geo->initFromGeoJSON($geojson);
        // return $geo;

        // Contoh data GeoJSON
        $geoJsonData = '{"type":"Feature","geometry":{"type":"Polygon","coordinates":[[[-74.0,40.7],[-74.0,40.8],[-73.9,40.8],[-73.9,40.7],[-74.0,40.7]]]},"properties":{}}';

        // Convert GeoJSON to array
        $geometry = json_decode($geoJsonData, true);

        // Inisialisasi pustaka ShapeFileWriter
        $shpWriter = new ShapeFileWriter(FCPATH.'upload/files/file.shp', Shapefile::SHAPE_TYPE_POLYGON);

        // Tambahkan geometri ke shapefile
        $shpWriter->addRecord($geometry);

        // Simpan shapefile
        $shpWriter->save();

        $output = '';
        echo 'Shapefile saved successfully.';
    }

    public function getShapeFileInfo($file){
        echo "<pre>";
            try {
                // Open Shapefile
                $Shapefile = new ShapefileReader($file);

                // Get Shape Type
                echo "Shape Type : ";
                echo $Shapefile->getShapeType() . " - " . $Shapefile->getShapeType(Shapefile::FORMAT_STR);
                echo "\n\n";
                
                // Get number of Records
                echo "Records : ";
                print_r($Shapefile->getTotRecords());
                echo "\n\n";
                
                // Get Bounding Box
                echo "Bounding Box : ";
                print_r($Shapefile->getBoundingBox());
                echo "\n\n";
                
                // Get PRJ
                echo "PRJ : ";
                print_r($Shapefile->getPRJ());
                echo "\n\n";
                
                // Get Charset
                echo "Charset : ";
                print_r($Shapefile->getCharset());
                echo "\n\n";
                
                // Get DBF Fields
                echo "DBF Fields : ";
                print_r($Shapefile->getFields());
                echo "\n\n";
                
            } catch (ShapefileException $e) {
                // Print detailed error information
                echo "Error Type: " . $e->getErrorType()
                    . "\nMessage: " . $e->getMessage()
                    . "\nDetails: " . $e->getDetails();
            }
        echo "</pre>";
    }
}