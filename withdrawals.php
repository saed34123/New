<?php
class Withdrawals {
    private $pdo;
    private $settings;
    
    public function __construct($pdo, $settings) {
        $this->pdo = $pdo;
        $this->settings = $settings;
    }
    
    public function request($userId, $amount, $paymentMethod, $paymentDetails) {
        try {
            // Validate minimum withdrawal
            $minWithdrawal = $this->settings->get('min_withdrawal');
            if ($amount < $minWithdrawal) {
                throw new Exception("Minimum withdrawal amount is " . $minWithdrawal);
            }
            
            // Calculate fee
            $feePercentage = $this->settings->get('withdrawal_fee');
            $fee = $amount * ($feePercentage / 100);
            $netAmount = $amount - $fee;
            
            $this->pdo->beginTransaction();
            
            $stmt = $this->pdo->prepare("
                INSERT INTO withdrawals 
                (user_id, amount, fee, net_amount, payment_method, payment_details)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $userId, 
                $amount, 
                $fee, 
                $netAmount, 
                $paymentMethod, 
                $paymentDetails
            ]);
            
            $this->pdo->commit();
            return [
                'success' => true,
                'withdrawal_id' => $this->pdo->lastInsertId(),
                'amount' => $amount,
                'fee' => $fee,
                'net_amount' => $netAmount
            ];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    public function process($withdrawalId, $status, $adminId, $notes = null) {
        try {
            $this->pdo->beginTransaction();
            
            $stmt = $this->pdo->prepare("
                UPDATE withdrawals 
                SET status = ?,
                    processed_by = ?,
                    processed_at = CURRENT_TIMESTAMP,
                    notes = ?
                WHERE id = ?
            ");
            
            $result = $stmt->execute([$status, $adminId, $notes, $withdrawalId]);
            
            $this->pdo->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    public function getUserWithdrawals($userId) {
        $stmt = $this->pdo->prepare("
            SELECT w.*, u.username as processed_by_username
            FROM withdrawals w
            LEFT JOIN users u ON w.processed_by = u.id
            WHERE w.user_id = ?
            ORDER BY w.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>