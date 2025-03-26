<?php
include '../components/connect.php';

if (!isset($_COOKIE['agent_id'])) {
    header('location:login.php');
    exit();
}

$filter_month = date('Y-m'); // Default to current month
$monthly_reports = [];
$rental_balance_reports = [];

if (isset($_POST['filter'])) {
    $filter_month = $_POST['filter_month'];
}

// Fetch Monthly Reports
$monthly_query = $conn->prepare("SELECT p.created_at, t.firstname, t.lastname, prop.property_name, p.invoice_number, p.amount 
    FROM payments p 
    JOIN tenants t ON p.tenant_id = t.id 
    JOIN property_1 prop ON t.property_id = prop.id 
    WHERE DATE_FORMAT(p.created_at, '%Y-%m') = :filter_month");
$monthly_query->execute(['filter_month' => $filter_month]);
$monthly_reports = $monthly_query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="agent_style.css">
    <style>
        .container {
            max-width: 1100px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="month"], button {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background: #007bff;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .print-btn {
            display: block;
            width: 150px;
            margin: 20px auto;
            background: #28a745;
            padding: 10px;
            color: white;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-btn:hover {
            background: #218838;
        }
        @media print {
            body * {
                visibility: hidden; /* Hide everything by default */
            }
            .print-area, .print-area * {
                visibility: visible; /* Show only the report content */
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                text-align: center;
            }
            
            /* Hide buttons and unnecessary UI elements */
            .print-btn, form, .dataTables_filter, .dataTables_length, .dataTables_info, .dataTables_paginate {
                display: none !important;
            }
    }
    </style>
</head>
<body>
<?php include '../components/agent_header.php'; ?>
<div class="container print-area">
    <h2>Monthly Reports</h2>
    <form method="post">
        <label>Select Month:</label>
        <input type="month" name="filter_month" value="<?= htmlspecialchars($filter_month); ?>">
        <button type="submit" name="filter">Filter</button>
    </form>
    <table id="reportTable" class="display">
        <thead>
            <tr>
                <th>Date</th>
                <th>Tenant</th>
                <th>Property</th>
                <th>Invoice</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monthly_reports as $report): ?>
                <tr>
                    <td><?= date('d M Y', strtotime($report['created_at'])); ?></td>
                    <td><?= htmlspecialchars($report['firstname'] . ' ' . $report['lastname']); ?></td>
                    <td><?= htmlspecialchars($report['property_name']); ?></td>
                    <td><?= htmlspecialchars($report['invoice_number']); ?></td>
                    <td>₦<?= number_format($report['amount'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button class="print-btn" onclick="window.print()">Print Report</button>
</div>


<script>
    function printReport() {
        window.print();
    }
</script>
<script>
    $(document).ready(function() {
        $('#reportTable').DataTable();
    });
</script>
<!-- custom js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
