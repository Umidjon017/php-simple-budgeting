<!DOCTYPE html>
<html>
  <head>
    <title>Transactions</title>
    <style>
      table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
      }
      table tr th, table tr td {
        padding: 5px;
        border: 1px #eee solid;
      }
      tfoot tr th, tfoot tr td {
        font-size: 20px;
      }
      tfoot tr th {
        text-align: right;
      }
    </style>
  </head>
  <body>
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Check #</th>
        <th>Description</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
    <?php if (! empty($transactions)): ?>
        <?php foreach ($transactions as $transaction): ?>
        <tr>
            <th> <?= formatDate($transaction['date']) ?> </th>
            <th> <?= $transaction['checkNumber'] ?> </th>
            <th> <?= $transaction['description'] ?> </th>
            <th>
                <?php if ($transaction['amount'] > 0): ?>
                    <span style="color: green">
                        <?= formatAmount($transaction['amount']) ?>
                    </span>
                <?php elseif ($transaction['amount'] < 0): ?>
                    <span style="color: red">
                        <?= formatAmount($transaction['amount']) ?>
                    </span>
                <?php else: ?>
                    <?= formatAmount($transaction['amount']) ?>
                <?php endif; ?>
            </th>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3">Total Income:</th>
        <td> <?= formatAmount($totals['incomeTotal'] ?? 0) ?> </td>
      </tr>
      <tr>
        <th colspan="3">Total Expense:</th>
        <td> <?= formatAmount($totals['expenseTotal'] ?? 0) ?> </td>
      </tr>
      <tr>
        <th colspan="3">Net Total:</th>
        <td> <?= formatAmount($totals['netTotal'] ?? 0) ?> </td>
      </tr>
    </tfoot>
  </table>
  </body>
</html>