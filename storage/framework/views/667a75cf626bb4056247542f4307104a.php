<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .company {
            font-size: 12px;
        }

        .info-table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 4px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .section-title {
            margin-top: 10px;
            font-weight: bold;
        }

        .totals {
            margin-top: 10px;
            text-align: right;
        }

        .signature {
            margin-top: 40px;
            width: 100%;
        }

        .signature td {
            text-align: center;
            padding-top: 30px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="title">PAYSLIP</div>
        <div class="company">Your Company Name</div>
        <div class="company">Payroll Period: <?php echo e($weekStart); ?> - <?php echo e($weekEnd); ?></div>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Name:</strong> <?php echo e($p['name']); ?></td>
            <td>
                <strong>Type:</strong>
                <?php echo e($p['person_type'] === 'helper' ? 'Helper' : 'Driver'); ?>

            </td>
        </tr>
    </table>

    <div class="section-title">INCOME</div>

    <table class="main-table">
        <tr>
            <th>DATE</th>
            <th>DESTINATION</th>
            <th>RATE</th>
            <th>AMOUNT</th>
            <th>ALLOWANCE</th>
            <th>TOTAL</th>
        </tr>

        <?php $__currentLoopData = $p['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($r['date']); ?></td>
                <td><?php echo e($r['location']); ?></td>
                <td><?php echo e(number_format($r['rate'] ?? 0, 2)); ?></td>
                <td><?php echo e(number_format($r['amount'] ?? 0, 2)); ?></td>
                <td><?php echo e(number_format($r['allowance'] ?? 0, 2)); ?></td>
                <td><?php echo e(number_format($r['total_salary'] ?? 0, 2)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <tr>
            <td colspan="5"><strong>TOTAL INCOME</strong></td>
            <td><strong>₱ <?php echo e(number_format($p['payroll_total'], 2)); ?></strong></td>
        </tr>
    </table>

    <div class="section-title">DEDUCTIONS</div>

    <table class="main-table">
        <tr>
            <th>ADVANCE</th>
            <th>SSS</th>
            <th>PAG-IBIG</th>
            <th>PHILHEALTH</th>
        </tr>
        <tr>
            <td><?php echo e(number_format($deductions['advanced'], 2)); ?></td>
            <td><?php echo e(number_format($deductions['sss'], 2)); ?></td>
            <td><?php echo e(number_format($deductions['pagibig'], 2)); ?></td>
            <td><?php echo e(number_format($deductions['philhealth'], 2)); ?></td>
        </tr>
    </table>

    <div class="totals">
        <p><strong>NET PAY: ₱ <?php echo e(number_format($netPay, 2)); ?></strong></p>
    </div>

    <table class="signature">
        <tr>
            <td>_________________________<br>Employer Signature</td>
            <td>_________________________<br>Employee Signature</td>
        </tr>
    </table>

</body>

</html>
<?php /**PATH C:\Users\HF-PC\Downloads\last zip\laravel_app\resources\views/pdf/myfile.blade.php ENDPATH**/ ?>