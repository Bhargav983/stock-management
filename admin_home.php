<?php
    require_once './includes/header.php';
    LogInCheck();
    require_once './includes/admin_nav.php';
    flash();
?>
<!--begin carousel-->
<div>
    <div class="container">
        <div class="row">
            <?php if ($_SESSION['role'] == 'admin') { ?>
                <div class="col-md-4">
                    <?php
                    require_once 'db.php';
                    // Dynamically use the dept_id from the session
                    $dept_id = $_SESSION['dept_id'];
                    $sql = "SELECT COUNT(`dept_id`) AS dept_available FROM `department` WHERE `dept_id` <> ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $dept_id);
                    $stmt->execute();
                    $result0 = $stmt->get_result();
                    $row = $result0->fetch_assoc();
                    $alert_dept = ($row['dept_available'] > 0) 
                        ? "<div class=''><h3 class='alert alert-success text-center'> Total Sites - " . $row['dept_available'] . "</h3></div>" 
                        : "<div class=''><h3 class='alert alert-danger'> NO DEPARTMENTS AVAILABLE </h3></div>";
                    echo $alert_dept;
                    ?>
                </div>
                <div class="col-md-4">
                <?php
            require_once 'db.php';
            $sql = "SELECT   COUNT(`supplier_id`) AS supplier_available FROM `supplier` WHERE 1";
            $result1 = $conn->query($sql);
            $row=$result1->fetch_assoc();
            $alert_supplier = ($row>0)? "<div class=''><h3 class='alert alert-success text-center'> Available Suppliers - ".$row['supplier_available']."</h3></div>":"<div class=''><h3 CLASS='alert alert-danger text-center'> NO SUPPLIER AVAILABLE </h3></div>";
            echo $alert_supplier;
            ?>
                </div>
                <div class="col-md-4">
                    <?php
                    $sql = "SELECT COUNT(`item_id`) AS item_available FROM `item` WHERE `dept_id` = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $dept_id);
                    $stmt->execute();
                    $result2 = $stmt->get_result();
                    $row = $result2->fetch_assoc();
                    $alert_item = ($row['item_available'] > 0) 
                        ? "<div class=''><h3 class='alert alert-success text-center'> Items In Stock - " . $row['item_available'] . "</h3></div>" 
                        : "<div class=''><h3 class='alert alert-danger'> NO ITEMS AVAILABLE </h3></div>";
                    echo $alert_item;
                    ?>
                </div>
            <?php } else if ($_SESSION['role'] == 'dept') { ?>
                <!-- Display department-specific data for non-admin users -->
                <div class="col-md-4">
                    <?php
                    require_once 'db.php';
                    $dept_id = $_SESSION['dept_id'];
                    $sql = "SELECT dept_name, dept_details FROM `department` WHERE `dept_id` = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $dept_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    if ($row) {
                        echo "<div class=''><h3 class='alert alert-success text-center'> Welcome " . $row['dept_name'] . " - " . $row['dept_details'] . "</h3></div>";
                    } else {
                        echo "<div class=''><h3 class='alert alert-danger'> DEPARTMENT DETAILS NOT FOUND </h3></div>";
                    }
                    ?>
                </div>
                <div class="col-md-4">
                    <!-- You can add other department-specific details or functionality here -->
                    <?php
                    $sql = "SELECT COUNT(`item_id`) AS item_available FROM `item` WHERE `dept_id` = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $dept_id);
                    $stmt->execute();
                    $result2 = $stmt->get_result();
                    $row = $result2->fetch_assoc();
                    $alert_item = ($row['item_available'] > 0) 
                        ? "<div class=''><h3 class='alert alert-success text-center'> Items In Stock - " . $row['item_available'] . "</h3></div>" 
                        : "<div class=''><h3 class='alert alert-danger'> NO ITEMS AVAILABLE </h3></div>";
                    echo $alert_item;
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php require_once './includes/footer.php'; ?>
