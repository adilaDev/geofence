<?php
// Source Github https://github.com/phayes/geoPHP
// API Docs https://geophp.net/api.html
include_once(FCPATH.'vendor\phayes\geophp\geoPHP.inc');

// Register autoloader
require_once(FCPATH.'vendor/gasparesganga/php-shapefile/src/Shapefile/ShapefileAutoloader.php');
Shapefile\ShapefileAutoloader::register();

// Import classes
use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Shapefile\ShapefileWriter;

class Converter extends CI_Model
{
    
    public function converterGeoJsonToShp(){
        // Contoh data GeoJSON
        $geoJsonData = '{"type":"Feature","geometry":{"type":"Polygon","coordinates":[[[-74.0,40.7],[-74.0,40.8],[-73.9,40.8],[-73.9,40.7],[-74.0,40.7]]]},"properties":{}}';
        
        // convert GeoJSON to Shp
        $polygon = geoPHP::load($geoJsonData,'json');
        $shp = $polygon->out('wkt');
        $multipoint_points = $polygon->getComponents();
        $line = $multipoint_points[0]->out('wkt');
        // Simpan sebagai Shapefile
        
        $output['shp'] = $shp;
        $output['line'] = $line;
        // $output['multipoint_points'] = $multipoint_points;
        // $output['polygon'] = $polygon;
        
        return $output;
    }

    public function convertShpToGeoJson($wktString){
        // Polygon WKT example geoPHP::load('POLYGON((1 1,5 1,5 5,1 5,1 1),(2 2,2 3,3 3,3 2,2 2))','wkt');
        $polygon = geoPHP::load($wktString,'wkt');
        $area = $polygon->getArea();
        $centroid = $polygon->getCentroid();
        $centX = $centroid->getX();
        $centY = $centroid->getY();

        $output['polygon'] = $polygon;
        $output['area'] = $area;
        $output['centroid'] = $centroid;
        $output['centX'] = $centX;
        $output['centY'] = $centY;
        return $output;
    }

    public function save(){
        // Contoh data GeoJSON
        $geoJsonData = '{"type":"Feature","geometry":{"type":"Polygon","coordinates":[[[-74.0,40.7],[-74.0,40.8],[-73.9,40.8],[-73.9,40.7],[-74.0,40.7]]]},"properties":{}}';

        // try {
            // Convert GeoJSON to Geometry
            $geometry = GeoPHP::load($geoJsonData, 'json');
            // Dapatkan WKT
            $wkt = $geometry->out('wkt');
            // $shapefilePath = FCPATH.'upload/files/polygon_shapefile.shp';
            $shapefilePath = 'upload/files/polygon_shapefile.shp';
            
            if (!is_readable($shapefilePath)) {
                $output['is_read'] = 'File is not readable.';
            }

            if (!is_writable($shapefilePath)) {
                $output['is_write'] = 'File is not writable.';
            }
            $output['geometry'] = $geometry;
            $output['wkt'] = $wkt;
            $output['is_read'] = is_readable($shapefilePath);
            $output['is_write'] = is_writable($shapefilePath);

            // if (is_readable($shapefilePath) && is_writable($shapefilePath)) {
            //     // Inisialisasi pustaka ShapeFileWriter
            //     $shpWriter = new ShapeFileWriter($shapefilePath);
            //     $shpWriter->setShapeType(Shapefile::SHAPE_TYPE_POLYGON);
    
            //     // Tambahkan record ke shapefile
            //     // $shpWriter->addCharField(['geometry' => $wkt]);
            //     // $shpWriter->addCharField('ID', 30);
            //     // $shpWriter->addShape(['geometry' => $wkt]);
    
            //     // Simpan shapefile
            //     // $shpWriter->save();
                
            //     // Write the record to the Shapefile
            //     $shpWriter->writeRecord($geometry);
            //     $output['shpWriter'] = $shpWriter;
            // }

            // echo 'Shapefile saved successfully.';
            // return $output;

        // } catch (ShapefileException $e) {
        //     // Print detailed error information
        //     // echo "Error Type: " . $e->getErrorType()
        //     //     . "\nMessage: " . $e->getMessage()
        //     //     . "\nDetails: " . $e->getDetails();
        //     $output['error'] = array(
        //         "ErrorType" => $e->getErrorType(),
        //         "Message" => $e->getMessage(),
        //         "Details" => $e->getDetails()
        //     );
        // }
        return $output;
    }
}