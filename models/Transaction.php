<?php

abstract class Transaction {
    protected $pdo;
    
    public function __construct() {
        $this->pdo = Database::connect();
    }
    
    abstract public function create($user_id, $titre, $category, $depense, $id);

    public function getUserTransactionsByCategory($user_id, $category) {
        $stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE user_id = ? AND category = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id, $category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM transactions WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public static function getTotalDepense($user_id) {
        $stmt = Self::$pdo->prepare("SELECT SUM(depense) AS total FROM transactions WHERE user_id = ? AND type = 'depense'");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}