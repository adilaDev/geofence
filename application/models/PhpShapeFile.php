<?php
// // Library PhpMyAdmin
// use PhpMyAdmin\ShapeFile\ShapeFile;
// use PhpMyAdmin\ShapeFile\ShapeRecord;
// use PhpMyAdmin\ShapeFile\ShapeType;
// https://github.com/phpmyadmin/shapefile
// https://develdocs.phpmyadmin.net/shapefile/PhpMyAdmin.html

// Load Composer autoloader
require 'vendor/autoload.php';

use phayes\GeoPHP\GeoJSON;
use phayes\GeoPHP\Geometry\GeometryCollection;
use phayes\GeoPHP\Geometry\Geometry;

class PhpShapeFile extends CI_Model
{
    public function getShapeFileInfo(){
    }

    public function converterGeoJsonToShp(){
        // Contoh data GeoJSON
        $geoJsonData = '{"type":"Feature","geometry":{"type":"Polygon","coordinates":[[[-74.0,40.7],[-74.0,40.8],[-73.9,40.8],[-73.9,40.7],[-74.0,40.7]]]},"properties":{}}';

        // Convert GeoJSON to Geometry
        $geometry = GeoJSON::load($geoJsonData);

        // Simpan sebagai Shapefile
        $result = $geometry->out('shapefile', 'output_shapefile');

        $output['geometry'] = $geometry;
        $output['result'] = $result;
        return $output;
    }
}