<?php

declare(strict_types = 1);

function getTransactionFiles(string $dirPath): array
{
    $files = [];

    foreach (scandir($dirPath) as $dir) {
        if (is_dir($dir)) {
            continue;
        }
        $files[] = $dirPath . $dir;
    }

    return $files;
}

function getTransactions(string $filename, ?callable $transactionsHandler = null): array
{
    $files = fopen($filename, 'r');

    fgetcsv($files);

    $transactions = [];
    while (($transaction = fgetcsv($files)) !== false) {
        if ($transactionsHandler !== null) {
            $transaction = $transactionsHandler($transaction);
        }

        $transactions[] = $transaction;
    }

    return $transactions;
}

function extractTransactions(array $transactionRows): array
{
    [$date, $checkNumber, $description, $amount] = $transactionRows;

    $amount = (float) str_replace(['$', ','], '', $amount);

    return [
        'date'          => $date,
        'checkNumber'   => $checkNumber,
        'description'   => $description,
        'amount'        => $amount
    ];
}

function calculateTotals(array $transactions): array
{
    $totals = ['netTotal' => 0, 'incomeTotal' => 0, 'expenseTotal' => 0];

    foreach ($transactions as $transaction) {
        $totals['netTotal'] += $transaction['amount'];

        if ($transaction['amount'] >= 0) {
            $totals['incomeTotal'] += $transaction['amount'];
        } else {
            $totals['expenseTotal'] += $transaction['amount'];
        }
    }

    return $totals;
}
