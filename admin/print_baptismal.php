<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Generator</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            margin: 0;
            padding: 0;
        }
        .certificate-container {
            width: 100%;
            height: 100vh;
            background-image: url('certificate_background.jpg'); /* Replace with your certificate image */
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .content {
            position: absolute;
            width: 80%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #000;
        }
        .editable-field {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        #print-button {
            margin: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #print-button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

<div class="certificate-container">
    <div class="content">
        <h1>Certificate of Achievement</h1>
        <p>This is to certify that</p>
        <div class="editable-field">
            <!-- Recipient's Name -->
            <?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Recipient Name'; ?>
        </div>
        <p>has successfully completed the program</p>
        <div class="editable-field">
            <!-- Program Name -->
            <?php echo isset($_GET['program']) ? htmlspecialchars($_GET['program']) : 'Program Name'; ?>
        </div>
        <p>Issued by</p>
        <div class="editable-field">
            <!-- Issuer Name -->
            <?php echo isset($_GET['issuer']) ? htmlspecialchars($_GET['issuer']) : 'Issuer Name'; ?>
        </div>
        <div class="editable-field">
            <!-- Issuer Position -->
            <?php echo isset($_GET['position']) ? htmlspecialchars($_GET['position']) : 'Position'; ?>
        </div>
        <p class="editable-field">
            <!-- Date -->
            Date: <?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : date('F j, Y'); ?>
        </p>
    </div>
</div>

<!-- Print Button -->
<button id="print-button" onclick="window.print()">Print Certificate</button>

</body>
</html>
