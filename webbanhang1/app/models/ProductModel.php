<?php
class ProductModel
{
    private $conn;
    private $table_name = "products";
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    // Lấy tất cả sản phẩm
    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, p.stock, c.name as category_name 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    // Thêm sản phẩm mới
    public function addProduct($name, $description, $price, $category_id, $image = null, $stock = 0)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (!is_numeric($stock) || $stock < 0) {
            $errors['stock'] = 'Số lượng sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image, stock) 
                  VALUES (:name, :description, :price, :category_id, :image, :stock)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':stock', $stock);

        return $stmt->execute();
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $name, $description, $price, $category_id, $image = null, $stock = 0)
    {
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description, price = :price, 
                  category_id = :category_id, image = :image, stock = :stock WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':stock', $stock);
        
        return $stmt->execute();
    }
    
    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>