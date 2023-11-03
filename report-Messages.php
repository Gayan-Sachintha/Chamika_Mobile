<?php
header("Content-type: application/json; charset=utf-8");

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

require_once('libs\pdflib\tcpdf.php');

$pdf = new TCPDF();

$pdf->AddPage('P', 'A4');

$html = '<html>
            <body>
                <h1>Pending Orders</h1>
                <table>
                <tr>
                  <th>User ID</th>
                  <th>Email</th>
                  <th>Name</th>
                  <th>Number</th>
                  <th>Message</th>
                </tr>';

$select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
if(mysqli_num_rows($select_message) > 0){
    while($fetch_message = mysqli_fetch_assoc($select_message)){
    $html .= "
              <tr>
                <td>" . $fetch_message['user_id'] . "</td>
                <td>" . $fetch_message['email'] . "</td>
                <td>" . $fetch_message['name'] . "</td>
                <td>" . $fetch_message['number'] . "</td>
                <td>" . $fetch_message['message'] . "</td>
              </tr>";
  }
}

$html .= "
          </table>
          </body>
          </html>";

$randomID = uniqid('', true);
$fileName = 'messagesReport-' . date("Y-m-d") . '-' . $randomID . '.pdf';
$outputFilePath = __DIR__ . '/reports/' . $fileName;

$pdf->writeHTML($html);

$pdf->Output($outputFilePath, 'F');

echo "File Saved in : " . $outputFilePath;
?>
