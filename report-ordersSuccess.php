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
                  <th>Placed Date</th>
                  <th>Total Products</th>
                  <th>Total Amount</th>
                </tr>';

$select_orders = mysqli_query($conn, "SELECT * FROM `orders` where `payment_status` = 'completed' ") or die('query failed');
if (mysqli_num_rows($select_orders) > 0) {
  while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
    $html .= "
              <tr>
                <td>" . $fetch_orders['user_id'] . "</td>
                <td>" . $fetch_orders['email'] . "</td>
                <td>" . $fetch_orders['placed_on'] . "</td>
                <td>" . $fetch_orders['total_products'] . "</td>
                <td>" . $fetch_orders['total_price'] . "</td>
              </tr>";
  }
}

$html .= "
          </table>
          </body>
          </html>";

$randomID = uniqid('', true);
$fileName = 'ordersSuccessReport-' . date("Y-m-d") . '-' . $randomID . '.pdf';
$outputFilePath = __DIR__ . '/reports/' . $fileName;

$pdf->writeHTML($html);

$pdf->Output($outputFilePath, 'F');

echo "File Saved in : " . $outputFilePath;
?>
