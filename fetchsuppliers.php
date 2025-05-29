<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM suppliers");
$supp = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <tr>
        <th>Supplier ID</th>
        <th>Supplier Name</th>
        <th>Contact</th>
        <th>Email</th>
    </tr>
    <?php foreach ($supplier as $supp): ?>
        <tr>
            <td><?= $supp['supplier_id'] ?></td>
            <td><?= $supp['supplier_name'] ?></td>
            <td><?= $supp['contact'] ?></td>
            <td><?= $supp['email'] ?></td>
           
      </tr>
    <?php endforeach; ?>
</table>
