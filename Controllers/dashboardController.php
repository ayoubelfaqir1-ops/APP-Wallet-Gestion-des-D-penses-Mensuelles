<?php

class dashboardController
{
    private $wallet;
    private $expenseObj;

    public function __construct()
    {
        $this->wallet = new Wallet();
        $this->expenseObj = new Expense();
    }

    public function showDashboard()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        $status = 'new';
        $walletData = $this->wallet->getwalletbymonth();
        $budget = 0;
        $totalExpenses = 0;
        $balance = 0;
        $transactions = [];
        $autoExpenses = [];
        
        if ($walletData) {
            $status = 'old';
            $budget = $walletData['budget_total'] ?? 0;
        }
        
        // Get transactions
        $expense = new Expense();
        $transactions = $expense->getUserTransactions($_SESSION['user_id']);
        
        // Calculate totals
        foreach ($transactions as $t) {
            $totalExpenses += $t['depense'];
        }
        $balance = $budget - $totalExpenses;
        
        // Get auto expenses
        $autoExpense = new AutoExpense();
        $autoExpenses = $autoExpense->getUserAutoExpenses($_SESSION['user_id']);
        
        require 'Views/dashboard.php';
    }

    public function setbudget()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        $budget = $_POST['budget'] ?? 0;
        $existing = $this->wallet->getwalletbymonth();
        
        if ($existing) {
            $this->wallet->updateBudgetTotal($budget);
        } else {
            $this->wallet->create($budget);
        }
        
        header('Location: /dashboard');
        exit();
    }

    public function addExpense()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        $type = $_POST['type'] ?? 'depense';
        $expense = $_POST['depense'] ?? 0;
        
        if ($type === 'autodepense') {
            $autoExpense = new AutoExpense();
            $autoExpense->create(
                $_SESSION['user_id'],
                $_POST['titre'] ?? '',
                $_POST['category'] ?? '',
                $expense,
                $_POST['day'] ?? 1
            );
        } else {
            $this->expenseObj->create(
                $_SESSION['user_id'],
                $_POST['titre'] ?? '',
                $_POST['category'] ?? '',
                $expense
            );
        }
        
        header('Location: /dashboard');
        exit();
    }
}