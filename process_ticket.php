<?php
require 'events_connect.php';
require_once __DIR__ . '/tcpdfmain/tcpdf.php';
require 'PHPMailer/vendor/autoload.php'; // Include PHPMailer
require 'phpqrcode/qrlib.php'; // Include QR code generator

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $number = htmlspecialchars($_POST['phone'] ?? ''); // Updated to match 'phone' field
    $event_id = (int) ($_POST['event_id'] ?? 0);
    $quantity = (int) ($_POST['quantity'] ?? 0);

    // Fetch event details from database using PDO
    $stmt = $conn->prepare("SELECT  eventname, event_date, location, price, image FROM events WHERE id = :event_id");
    $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        die("Event not found.");
    }

    $eventname = $event['eventname'];
    $event_date = $event['event_date'];
    $location = $event['location'];
    $price = (float) $event['price'];
    $event_image = $event['image'];
    $total_price = $quantity * $price;

    // Generate a unique ticket ID
    $ticketID = uniqid('TICKET_');

    // Generate QR Code
    $qrcode_path = 'qrcodes/' . $ticketID . '.png'; // Corrected file extension
    if (!is_dir('qrcodes')) {
        mkdir('qrcodes', 0777, true);
    }
    QRcode::png("Event: $eventname\nTicket ID: $ticketID\nOrder Date: $event_date\nLocation: $location\nName: $name\nPhone: $number\nEmail: $email", $qrcode_path, QR_ECLEVEL_L, 4);

    // Create PDF using TCPDF
    try {
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Cycling Events');
        $pdf->SetTitle('Event Ticket');
        $pdf->SetHeaderData(null, 0, 'Cycling Event Ticket', 'Your Entry Pass');
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Ticket Table Layout
        $html = "
        <h2 style='text-align:center;'>$eventname</h2>
        <table border='1' cellpadding='3'>
            <tr>
                <td><b>Ticket ID:</b> $ticketID</td>
                <td><b>Order Date:</b> $event_date</td>
            </tr>
            <tr>
                <td><b>Name:</b> $name</td>
                <td><b>Phone:</b> $number</td>
                <td><b>Email:</b> $email</td>
            </tr>
            <tr>
                <td><b>Quantity:</b> $quantity</td>
                <td><b>Unit Price:</b> Ksh $price</td>
                <td><b>Total:</b> Ksh $total_price</td>
                <td><b>Location:</b> $location</td>
            </tr>
        </table>
        <br>
        <p style='text-align:center;'>Thank you for your purchase! Enjoy the event.</p>
        ";

        $pdf->writeHTML($html, true, false, true, false, '');

        // Insert Event Image
        if ($event_image) {
            $image_path = 'uploads/' . $event_image;
            if (file_exists($image_path)) {
                $pdf->Image($image_path, 15, $pdf->GetY(), 80);
            }
        }

        // Insert QR Code event_images/
        $pdf->Image($qrcode_path, 110, $pdf->GetY(), 50);

        // Ensure 'tickets' directory exists
        if (!is_dir('tickets')) {
            mkdir('tickets', 0777, true);
        }

        // Save PDF to server
        $filePath = __DIR__ . "/tickets/$ticketID.pdf";
        $pdf->Output($filePath, 'F');
    } catch (Exception $e) {
        die("Error generating PDF: " . $e->getMessage());
    }

    // Send Email with PDF attachment
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nicole.wachira2@gmail.com'; // Update with your email
        $mail->Password = 'ybcahlwsyjoolugj'; // Use App Password (never share plain passwords!)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('nicole.wachira2@gmail.com', 'Cycling Events');
        $mail->addAddress($email, $name);
        $mail->Subject = 'Cycling Event Ticket Confirmation/Download';
        $mail->Body = "Hello $name,\n\nAttached is your ticket for the event: $eventname.\n\nWe're all about bringing Cyclers together, and we're thrilled to see you supporting the talent you love. ❤️\n\nEnjoy your ride!";
        $mail->addAttachment($filePath);

        if ($mail->send()) {
            echo "<p>Email sent successfully!</p>";
        } else {
            throw new Exception("Mailer Error: " . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        die("Error sending email: " . $e->getMessage());
    }

    // Provide download link dynamically
    echo "<p><a href='tickets/$ticketID.pdf' download>Download Your Ticket</a></p>";
}
?>
