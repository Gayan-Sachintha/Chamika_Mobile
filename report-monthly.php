<?php
header("Content-type: application/json; charset=utf-8");

require_once('libs\pdflib\tcpdf.php');

$pdf = new TCPDF();

$pdf->AddPage('P', 'A4');

$html = '<html>
            <body>
                <h1>Monthly Report</h1>
                <table>
                <tr>
                  <th>Name</th>
                  <th>Value</th>
                </tr>

                <tr>
                  <td>Total Pendings</td>
                  <td>'.$_GET['totalPendings'].'</td>
                </tr>

                <tr>
                  <td>Completed Payments</td>
                  <td>'.$_GET['completedPayments'].'</td>
                </tr>
                <tr>
                  <td>Order Placed</td>
                  <td>'.$_GET['orderPlaced'].'</td>
                </tr>
                <tr>
                  <td>Products Added</td>
                  <td>'.$_GET['productsAdded'].'</td>
                </tr>
                <tr>
                  <td>Normal Users</td>
                  <td>'.$_GET['normalUsers'].'</td>
                </tr>
                <tr>
                  <td>Admin Users</td>
                  <td>'.$_GET['adminUsers'].'</td>
                </tr>
                <tr>
                  <td>Total Accounts</td>
                  <td>'.$_GET['totalAccounts'].'</td>
                </tr>
                <tr>
                  <td>New Messages</td>
                  <td>'.$_GET['newMessages'].'</td>
                </tr>

              </table>
            </body>
        </html>';

$randomID = uniqid('', true);
$fileName = 'monthlyReport-'.date("Y-m-d").''.$randomID.'.pdf';
$outputFilePath = __DIR__.'/reports/'.$fileName;  

$pdf->writeHTML($html);

$pdf->Output($outputFilePath, 'F');

echo "File Saved in : " . $outputFilePath;
?>




