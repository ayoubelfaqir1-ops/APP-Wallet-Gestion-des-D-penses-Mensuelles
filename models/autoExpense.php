<?php
class AutoExpense
{
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::connect();
        $this->createTableIfNotExists();
    }
    
    private function createTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS auto_expenses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            titre VARCHAR(255) NOT NULL,
            category VARCHAR(100) NOT NULL,
            depense DECIMAL(10,2) NOT NULL,
            day_of_month INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }
    
    public function create($user_id, $titre, $category, $depense, $day) {
        $stmt = $this->pdo->prepare("INSERT INTO auto_expenses (user_id, titre, category, depense, day_of_month) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$user_id, $titre, $category, $depense, $day]);
    }
    
    public function getUserAutoExpenses($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM auto_expenses WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function processMonthlyExpenses($user_id) {
        $today = date('j');
        $stmt = $this->pdo->prepare("SELECT * FROM auto_expenses WHERE user_id = ? AND day_of_month = ?");
        $stmt->execute([$user_id, $today]);
        $autoExpenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $transaction = new Transaction();
        foreach ($autoExpenses as $expense) {
            $transaction->create($user_id, $expense['titre'], $expense['category'], $expense['depense'], 'autodepense');
        }
        
        return count($autoExpenses);
    }
}