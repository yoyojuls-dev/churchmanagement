<?php 
include('header.php'); 
include('session.php');

// Check if certificate ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: baptismal_certificates.php");
    exit();
}

$certificate_id = $_GET['id'];

// Fetch certificate data with member information
$cert_query = mysqli_query($conn, "SELECT bc.*, m.fname, m.lname, m.Gender, m.Birthday, m.pob, m.mobile 
                                   FROM baptismal_certificates bc 
                                   JOIN members m ON bc.member_id = m.id 
                                   WHERE bc.certificate_id = '$certificate_id'") or die(mysqli_error());

$certificate_data = mysqli_fetch_array($cert_query);

if(!$certificate_data) {
    header("location: baptismal_certificates.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Baptism - <?php echo $certificate_data['fname'] . ' ' . $certificate_data['lname']; ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Crimson+Text:wght@400;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Crimson Text', serif;
            background: linear-gradient(135deg, #f5f3f0 0%, #e8e2d4 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .certificate-container {
            width: 11in;
            height: 8.5in;
            background: #ffffff;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .certificate-border {
            position: absolute;
            top: 40px;
            left: 40px;
            right: 40px;
            bottom: 40px;
            border: 3px solid #8B4513;
            border-radius: 15px;
        }
        
        .inner-border {
            position: absolute;
            top: 55px;
            left: 55px;
            right: 55px;
            bottom: 55px;
            border: 1px solid #D2B48C;
            border-radius: 10px;
        }
        
        .decorative-corners {
            position: absolute;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, #DAA520 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0.1;
        }
        
        .corner-tl { top: 20px; left: 20px; }
        .corner-tr { top: 20px; right: 20px; }
        .corner-bl { bottom: 20px; left: 20px; }
        .corner-br { bottom: 20px; right: 20px; }
        
        .certificate-content {
            position: relative;
            padding: 80px 100px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            z-index: 10;
        }
        
        .header {
            margin-bottom: 30px;
        }
        
        .church-name {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #2C1810;
            margin-bottom: 8px;
            letter-spacing: 2px;
        }
        
        .certificate-title {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 700;
            color: #8B4513;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .subtitle {
            font-size: 24px;
            color: #5D4E37;
            font-style: italic;
            margin-bottom: 20px;
        }
        
        .cross-symbol {
            font-size: 36px;
            color: #DAA520;
            margin: 15px 0;
        }
        
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.8;
        }
        
        .proclamation {
            font-size: 20px;
            color: #2C1810;
            margin-bottom: 30px;
            font-style: italic;
        }
        
        .member-name {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 700;
            color: #8B4513;
            margin: 20px 0;
            text-decoration: underline;
            text-decoration-color: #DAA520;
            text-underline-offset: 8px;
        }
        
        .details-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin: 40px 0;
            font-size: 16px;
        }
        
        .detail-item {
            text-align: left;
            padding: 15px;
            background: rgba(218, 165, 32, 0.05);
            border-radius: 8px;
            border-left: 4px solid #DAA520;
        }
        
        .detail-label {
            font-weight: 600;
            color: #5D4E37;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        
        .detail-value {
            color: #2C1810;
            font-size: 16px;
            font-weight: 500;
        }
        
        .witnesses-section {
            grid-column: 1 / -1;
            text-align: center;
        }
        
        .witnesses-text {
            white-space: pre-line;
            line-height: 1.6;
        }
        
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #DAA520;
        }
        
        .signature-section {
            text-align: center;
            flex: 1;
        }
        
        .signature-line {
            width: 200px;
            height: 2px;
            background: #8B4513;
            margin: 30px auto 10px;
        }
        
        .signature-label {
            font-size: 14px;
            color: #5D4E37;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .signature-name {
            font-size: 16px;
            color: #2C1810;
            font-weight: 600;
            margin-top: 5px;
        }
        
        .certificate-info {
            text-align: center;
        }
        
        .certificate-number {
            font-size: 14px;
            color: #5D4E37;
            margin-bottom: 5px;
        }
        
        .generation-date {
            font-size: 12px;
            color: #8B7355;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(218, 165, 32, 0.03);
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            z-index: 1;
            pointer-events: none;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #8B4513;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            font-family: 'Crimson Text', serif;
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #A0522D;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .certificate-container {
                box-shadow: none;
                width: 100%;
                height: 100vh;
            }
            
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ Print Certificate</button>
    
    <div class="certificate-container">
        <!-- Decorative corners -->
        <div class="decorative-corners corner-tl"></div>
        <div class="decorative-corners corner-tr"></div>
        <div class="decorative-corners corner-bl"></div>
        <div class="decorative-corners corner-br"></div>
        
        <!-- Borders -->
        <div class="certificate-border"></div>
        <div class="inner-border"></div>
        
        <!-- Watermark -->
        <div class="watermark">BAPTIZED</div>
        
        <div class="certificate-content">
            <div class="header">
                <div class="church-name"><?php echo !empty($certificate_data['church_location']) ? strtoupper($certificate_data['church_location']) : 'ST. MARY\'S PARISH CHURCH'; ?></div>
                <div class="certificate-title">Certificate of Baptism</div>
                <div class="subtitle">In the Name of the Father, Son, and Holy Spirit</div>
                <div class="cross-symbol">✝</div>
            </div>
            
            <div class="main-content">
                <div class="proclamation">
                    This is to certify that
                </div>
                
                <div class="member-name">
                    <?php echo strtoupper($certificate_data['fname'] . ' ' . $certificate_data['lname']); ?>
                </div>
                
                <div class="proclamation">
                    was baptized according to the rites of the Christian Church
                </div>
                
                <div class="details-section">
                    <div class="detail-item">
                        <div class="detail-label">Date of Baptism</div>
                        <div class="detail-value">
                            <?php echo date('F j, Y', strtotime($certificate_data['baptism_date'])); ?>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Date of Birth</div>
                        <div class="detail-value">
                            <?php echo date('F j, Y', strtotime($certificate_data['Birthday'])); ?>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Place of Birth</div>
                        <div class="detail-value">
                            <?php echo $certificate_data['pob']; ?>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Gender</div>
                        <div class="detail-value">
                            <?php echo $certificate_data['Gender']; ?>
                        </div>
                    </div>
                    
                    <?php if(!empty($certificate_data['witnesses'])): ?>
                    <div class="detail-item witnesses-section">
                        <div class="detail-label">Witnesses</div>
                        <div class="detail-value witnesses-text">
                            <?php echo nl2br(htmlspecialchars($certificate_data['witnesses'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Notes section (if any) -->
                <?php if(!empty($certificate_data['notes'])): ?>
                <div style="margin-top: 20px; font-style: italic; color: #5D4E37; padding: 15px; background: rgba(218, 165, 32, 0.05); border-radius: 8px;">
                    <strong>Special Notes:</strong> <?php echo htmlspecialchars($certificate_data['notes']); ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="footer">
                <div class="signature-section">
                    <div class="signature-line"></div>
                    <div class="signature-label">Officiant</div>
                    <div class="signature-name">
                        <?php echo $certificate_data['baptized_by']; ?>
                    </div>
                </div>
                
                <div class="certificate-info">
                    <div class="certificate-number">
                        Certificate No: <?php echo $certificate_data['certificate_number']; ?>
                    </div>
                    <div class="generation-date">
                        Generated on: <?php echo date('F j, Y'); ?>
                    </div>
                    <div class="generation-date">
                        By: <?php echo $certificate_data['generated_by']; ?>
                    </div>
                </div>
                
                <div class="signature-section">
                    <div class="signature-line"></div>
                    <div class="signature-label">Parish Seal</div>
                    <div class="signature-name">Official Seal</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus for printing
        window.onload = function() {
            // Optional: Auto-print when page loads (uncomment if desired)
            // window.print();
        }
    </script>
</body>
</html>