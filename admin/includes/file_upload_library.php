<?php
require '../vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;
use Aws\S3\S3Client;

class FileUpload{
    public $tmpPath = __DIR__.'/../../tmp/';
    public $folder = 'cv/';

    private $version = 'latest';
    private $region = 'us-east-1';
    private $access_key_id = 'IZYPG0S914BQY629FNVX';
    private $secret_access_key = '30RDjdqaCHNfJzXoswDUcKUoO7JVIr4vSaZNblNU';
    private $endpoint = 'http://us-east-1.linodeobjects.com';
    private $bucket = 'topremotestaff';

    //public $objectKey = $folder . '/your-file-key-in-minio';


    public function convertDocToPDF($inputFile, $outputFile) {
        // Load the doc or docx file
        $phpWord = IOFactory::load($inputFile);

        // Save it as a temporary HTML file
        $tempHtml = tempnam(sys_get_temp_dir(), 'word');
        IOFactory::createWriter($phpWord, 'HTML')->save($tempHtml);

        // Convert the HTML file to PDF
        $dompdfOptions = new Options();
        $dompdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($dompdfOptions);
        $dompdf->loadHtml(file_get_contents($tempHtml));
        $dompdf->render();
        file_put_contents($outputFile, $dompdf->output());

        // Cleanup temporary file
        unlink($tempHtml);
    }

    public function uploadfiletostorage($file_name, $outputFile){
        // Instantiate an Amazon S3 client
        $s3 = new S3Client([
            'version' => $this->version,
            'region'  => $this->region,
            'endpoint'  => $this->endpoint,
            'credentials' => [
                'key'    => $this->access_key_id,
                'secret' => $this->secret_access_key,
            ]
        ]);


        // Upload file to S3 bucket
        try {
            $result = $s3->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $this->folder.$file_name,
                'ACL'    => 'public-read',
                'SourceFile' => $outputFile
            ]);
            $result_arr = $result->toArray();

            if(!empty($result_arr['ObjectURL'])) {
                $s3_file_link = $result_arr['ObjectURL'];
            } else {
                $api_error = 'Upload Failed! S3 Object URL not found.';
            }
        } catch (Aws\S3\Exception\S3Exception $e) {
            $api_error = $e->getMessage();
        }
        if(empty($api_error)){
            return true;
        }else {
            return false;
        }
    }

    public function deletefilefromstorage($fileName){
        // Initialize the S3 client
        $s3 = new S3Client([
            'version' => $this->version,
            'region'  => $this->region,
            'endpoint'  => $this->endpoint,
            'credentials' => [
                'key'    => $this->access_key_id,
                'secret' => $this->secret_access_key,
            ]
        ]);

//        $bucketName = 'your_bucket_name';
//        $objectKey = 'path/to/your/file.txt'; // Replace with the object key of the file you want to delete

        try {
            $s3->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $this->folder.$fileName,
            ]);

            $api_error = false;
        } catch (Exception $e) {
            $api_error = true;
            echo "Error deleting file: " . $e->getMessage() . "\n";
        }

        if(empty($api_error)){
            return true;
        }else {
            return false;
        }
    }

}

?>