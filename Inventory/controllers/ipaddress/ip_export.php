<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    /**------------------------ */

    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;

    // Load an existing Excel file
    $inputFile = '../../assets/files/ip_export.xlsx'; // Change this to your file path
    $spreadsheet = IOFactory::load($inputFile);

    // Get the active sheet
    $sheet = $spreadsheet->getActiveSheet();

    /**------------------------ */

    $response = [
        "status" => false,
        "type" => "error",
        "size" => null,
        "message" => "Something went wrong, please try again."
    ];

    if($data["id"]) {
        $ip = new IP_Network;
        $ip = DB::find($ip,$data["id"])[0];

        // Edit a cell (Example: Change A1 value)
        $sheet->setCellValue('B1', 'Sample User');
        $sheet->setCellValue('B2', 'Sample Date');

        // Save as another file
        $outputFile = '../../assets/temp/'.$ip['name'].'.xlsx'; // Change this to your desired output file name
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($outputFile);
    }
    echo json_encode($outputFile);
?>