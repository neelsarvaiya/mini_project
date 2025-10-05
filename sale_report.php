<?php
$con = mysqli_connect("localhost", "root", "Neel21@&", "php");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$range = isset($_GET['range']) ? $_GET['range'] : '7days';

$start = '';
$end = '';

switch ($range) {
    case 'today':
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');
        break;
    case '7days':
        $start = date('Y-m-d 00:00:00', strtotime('-7 days'));
        $end = date('Y-m-d 23:59:59');
        break;
    case 'month':
        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-t 23:59:59');
        break;
    case 'custom':
        $start = !empty($_GET['start']) ? $_GET['start'] . ' 00:00:00' : '';
        $end = !empty($_GET['end']) ? $_GET['end'] . ' 23:59:59' : '';
        break;
}

$where = '';
if ($start && $end) {
    $startEsc = mysqli_real_escape_string($con, $start);
    $endEsc = mysqli_real_escape_string($con, $end);
    $where = "WHERE created_at BETWEEN '$startEsc' AND '$endEsc'";
}
$sql = "SELECT items FROM orders $where ORDER BY created_at DESC";
$result = mysqli_query($con, $sql);

$sales = [];
$totalSales = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $items = json_decode($row['items'], true);
    if (!$items)
        continue;
    foreach ($items as $item) {
        $pid = (int) $item['product_id'];
        $qty = (int) $item['quantity'];
        $price = (float) $item['price'];

        if (!isset($sales[$pid])) {
            $pRes = mysqli_query($con, "SELECT product_name FROM products WHERE id=$pid");
            $pRow = mysqli_fetch_assoc($pRes);
            $sales[$pid] = [
                'name' => $pRow ? $pRow['product_name'] : "Unknown",
                'qty' => 0,
                'total' => 0
            ];
        }
        $sales[$pid]['qty'] += $qty;
        $sales[$pid]['total'] += $price;

        round($totalSales += $price);
    }
}

if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=product_sales_report.xls");
    echo "Product\tQuantity Sold\tTotal Sales\n\n";
    foreach ($sales as $s) {
        echo "{$s['name']}\t{$s['qty']}\t{$s['total']}\n";
    }
    echo "\nTotal\t       -\t{$totalSales}\n";
    exit;
}

include_once('admin_header.php');
?>

<div class="container my-4">
    <h2 class="mb-4 d-flex align-items-center gap-2">
        <i class="fa-solid fa-chart-line text-primary"></i> Product Sales Report
    </h2>

    <form id="salesForm" method="get" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="range" id="range" class="form-select" onchange="toggleCustomDates()">
                <option value="today" <?= ($range == 'today') ? 'selected' : '' ?>>Today</option>
                <option value="7days" <?= ($range == '7days') ? 'selected' : '' ?>>Last 7 Days</option>
                <option value="month" <?= ($range == 'month') ? 'selected' : '' ?>>This Month</option>
                <option value="custom" <?= ($range == 'custom') ? 'selected' : '' ?>>Custom Range</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="start" id="start" value="<?= isset($_GET['start']) ? $_GET['start'] : '' ?>"
                class="form-control">
            <div style=" color: red;
                        font-size: 0.9em;
                        margin-top: 4px;" id="starterror"></div>
        </div>
        <div class="col-md-3">
            <input type="date" name="end" id="end" value="<?= isset($_GET['end']) ? $_GET['end'] : '' ?>"
                class="form-control">
            <div style=" color: red;
                        font-size: 0.9em;
                        margin-top: 4px;" id="endterror"></div>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary" type="submit">Filter</button>
            <a href="?range=<?= $range ?>&start=<?= isset($_GET['start']) ? $_GET['start'] : '' ?>&end=<?= isset($_GET['end']) ? $_GET['end'] : '' ?>&export=excel"
                class="btn btn-success">Export to Excel</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Quantity Sold</th>
                <th>Total Sales (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($sales)): ?>
                <tr>
                    <td colspan="3" class="text-center">No sales found for selected range.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($sales as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['name']) ?></td>
                        <td><?= $s['qty'] ?></td>
                        <td><?= round($s['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="fw-bold">Total</td>
                    <td class="fw-bold">-</td>
                    <td class="fw-bold"><?=$totalSales?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function toggleCustomDates() {
        var range = document.getElementById('range').value;
        var isCustom = (range === 'custom');
        document.getElementById('start').disabled = !isCustom;
        document.getElementById('end').disabled = !isCustom;

        document.getElementById('starterror').textContent = '';
        document.getElementById('endterror').textContent = '';
    }

    // --- Validate only when "Custom Range" is selected ---
    document.getElementById('salesForm').addEventListener('submit', function (e) {
        var range = document.getElementById('range').value;
        if (range === 'custom') {
            var start = document.getElementById('start').value.trim();
            var end = document.getElementById('end').value.trim();
            var valid = true;

            if (!start) {
                document.getElementById('starterror').innerText = 'Start date is required';
                valid = false;
            } else {
                document.getElementById('starterror').innerText = '';
            }

            if (!end) {
                document.getElementById('endterror').innerText = 'End date is required';
                valid = false;
            } else {
                document.getElementById('endterror').innerText = '';
            }

            if (start && end && new Date(start) > new Date(end)) {
                document.getElementById('endterror').textContent = 'End date cannot be before start date';
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }
        }
    });

    toggleCustomDates();
</script>

<?php include_once('admin_footer.php'); ?>