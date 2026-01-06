<?php
class Wallet
{
    private $pdo;
    private $user_id;

    public function __construct()
    {
        $this->pdo = Database::connect();
        $this->user_id = $_SESSION['user_id'];
    }

    public function create($budget_total = 0)
    {
        $currentMonth = date('Y-m');
        $stmt = $this->pdo->prepare("INSERT INTO wallets (user_id, budget_total, month) VALUES (?, ?, ?)");
        return $stmt->execute([$_SESSION['user_id'], $budget_total, $currentMonth]);
    }

    public function getUserWallet($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM wallets WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function setBudgetTotal($budget_total)
    {
        $stmt = $this->pdo->prepare("UPDATE wallets SET budget_total = ? WHERE user_id = ?");
        $stmt->execute([$budget_total, $_SESSION['user_id']]);
    }

    public function updateBudgetTotal($budget_total)
    {
        $stmt = $this->pdo->prepare("UPDATE wallets SET budget_total = ? WHERE user_id = ?");
        $stmt->execute([$budget_total, $_SESSION['user_id']]);
    }
    public function getBudgetTotal()
    {
        $stmt = $this->pdo->prepare("SELECT budget_total FROM wallets WHERE user_id = ?");
        $stmt->execute([$this->user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['budget_total'];
    }

    public function setSoldeRestant()
    {
        $budget_total = $this->getBudgetTotal();
        $depense_total = Transaction::getTotalDepense($this->user_id);
        $stmt = $this->pdo->prepare("UPDATE wallets SET solde_restant = ? WHERE user_id = ?");
        $stmt->execute([$budget_total - $depense_total, $this->user_id]);
        return $budget_total - $depense_total;
    }

    public function getwalletbymonth()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM wallets WHERE user_id = ? AND month = ?");
        $stmt->execute([$_SESSION['user_id'], date('Y-m')]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateSoldeRestant($expense)
    {
        $stmt = $this->pdo->prepare("UPDATE wallets SET solde_restant = solde_restant - ? WHERE user_id = ?");
        $stmt->execute([$expense, $this->user_id]);
    } 
}
