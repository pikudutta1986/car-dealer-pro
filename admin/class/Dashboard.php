<?php
class Dashboard
{
    // Connection instance
    private $connection;

    // Db connection
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getCarsAvailable()
    {
        $query = "SELECT COUNT(id) AS availablecars FROM cars_listings WHERE status='AVAILABLE'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['availablecars'];
    }

    public function getCarsSold()
    {
        $query = "SELECT COUNT(sale_id) AS soldcars FROM cars_sale";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['soldcars'];
    }

    public function getTotalSale()
    {
        $query = "SELECT SUM(sale_price) AS totalsale FROM cars_sale";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['totalsale'];
    }

    public function getTotalProfit()
    {
        $query = "SELECT SUM(sale_price - owner_price) AS totalprofit FROM cars_sale";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['totalprofit'];
    }

}