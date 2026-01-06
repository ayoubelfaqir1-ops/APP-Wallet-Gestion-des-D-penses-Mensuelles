<?php
class Expense
{
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function create($user_id, $titre, $category, $depense, $wallet_id = null){
        $stmt = $this->pdo->prepare("INSERT INTO transactions (user_id, titre, category, depense, type) VALUES (?, ?, ?, ?, 'depense')");
        return $stmt->execute([$user_id, $titre, $category, $depense]);
    }

    public function getUserTransactions($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}