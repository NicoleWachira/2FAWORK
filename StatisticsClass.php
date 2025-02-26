<?php
class Statistics {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalEvents() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total_events FROM events");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_events'];
    }

    public function getTotalTicketsSold() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total_tickets FROM tickets");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_tickets'];
    }

    public function getTotalRevenue() {
        $stmt = $this->pdo->query("SELECT SUM(price) AS total_revenue FROM tickets");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];
    }

    public function getHighestRevenueEvent() {
        $stmt = $this->pdo->query("
            SELECT e.event_name, SUM(t.price) AS revenue 
            FROM tickets t 
            JOIN events e ON t.event_id = e.id 
            GROUP BY e.event_name 
            ORDER BY revenue DESC 
            LIMIT 1
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLowestRevenueEvent() {
        $stmt = $this->pdo->query("
            SELECT e.event_name, SUM(t.price) AS revenue 
            FROM tickets t 
            JOIN events e ON t.event_id = e.id 
            GROUP BY e.event_name 
            ORDER BY revenue ASC 
            LIMIT 1
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRevenueData() {
        $stmt = $this->pdo->query("
            SELECT e.event_name, SUM(t.price) AS revenue 
            FROM tickets t 
            JOIN events e ON t.event_id = e.id 
            GROUP BY e.event_name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
