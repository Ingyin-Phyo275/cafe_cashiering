<?php

class Order {
    private $orderItems = [];
    private $totalPrice = 0;

    public function addItem($menuId, $menuName, $price, $quantity = 1) {
        if (isset($this->orderItems[$menuId])) {
            $this->orderItems[$menuId]['quantity'] += $quantity;
        } else {
            $this->orderItems[$menuId] = [
                'name' => $menuName,
                'price' => $price,
                'quantity' => $quantity,
                'totalPrice' => $price * $quantity // Ensure totalPrice is set
            ];
        }
        $this->updateTotalPrice();
    }
    
    private function updateTotalPrice() {
        $this->totalPrice = 0;
        foreach ($this->orderItems as &$item) { // Pass $item by reference to modify totalPrice directly
            $item['totalPrice'] = $item['price'] * $item['quantity'];
            $this->totalPrice += $item['totalPrice'];
        }
    }
    
    public function removeItem($menuId) {
        if (isset($this->orderItems[$menuId])) {
            unset($this->orderItems[$menuId]);
            $this->updateTotalPrice();
        }
    }

    public function updateItemQuantity($menuId, $quantity) {
        if (isset($this->orderItems[$menuId])) {
            $this->orderItems[$menuId]['quantity'] = $quantity;
            $this->updateTotalPrice();
        }
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function getOrderItems() {
        return $this->orderItems;
    }

    public function clearOrder() {
        $this->orderItems = [];
        $this->totalPrice = 0;
    }

    public function saveOrder($db) {
        date_default_timezone_set('Asia/Yangon');
        $currentDateTime = date('Y-m-d h:i:s');
    
        // Insert into sales table
        $totalPrice = $this->getTotalPrice(); // Assign to a variable first
        $stmt = $db->prepare("INSERT INTO sales (total, sale_date) VALUES (?, ?)");
        $stmt->bind_param("ds", $totalPrice, $currentDateTime);
        $stmt->execute();
        $saleId = $stmt->insert_id;
    
        // Insert order items into sale_item table
        $stmt = $db->prepare("INSERT INTO sale_item (sale_id, menu_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($this->orderItems as $menuId => $item) {
            $quantity = $item['quantity']; // Assign to variables to avoid passing references directly
            $price = $item['price']*$quantity;
            $stmt->bind_param("iiid", $saleId, $menuId, $quantity, $price);
            $stmt->execute();
        }
    
        $stmt->close();
    }
}
?>
