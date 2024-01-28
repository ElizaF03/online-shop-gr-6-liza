<?php


require_once 'Model.php';
class  Product extends Model
{
public function getAll():array
{
$stmt=$this->pdo->query('SELECT * FROM products');
return $stmt->fetchAll();
}
public function getOne($id)
{
    $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id =:id LIMIT 1');
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}
}