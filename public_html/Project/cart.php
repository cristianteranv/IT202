<?php
    include("header.php");
    require_once("common.inc.php");
    echo "<title>Your cart</title><h1>Cart Items</h1>";
    if(get($_SESSION,"user",false)){
        $userId = $_SESSION["user"]["id"];
        $total = 0;
        try{
            $stmt = getDB()->prepare("SELECT c.id, p.name, c.price, c.quantity, c.quantity*c.price as total, c.created FROM Carts c, Products p WHERE c.userId = :userId AND c.productId = p.id ORDER BY c.created");
            $stmt->execute(array(":userId" => $userId));
            //total = SELECT SUM(price*quantity) as total FROM Carts WHERE userId = :userId
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);?>
            <?php if(isset($results) && count($results) > 0):?>
                <ul class="itemList">
                    <li class="itemHeader">
                        <a class="itemCell">Name</a>
                        <a class="itemCell">Price</a>
                        <a class="itemCell">Quantity</a>
                        <a class="itemCell">Total price</a>
                    </li>
            <?php foreach($results as $row):?>
                    <li class="itemListing" style="height:">
                        <a class="itemCell" style="width: 50px"><?php echo get($row, "name")?></a>
                        <a class="itemCell" style="width: 100px"><?php echo get($row, "price")?></a>
                        <a class="itemCell" style="width: 100px"><?php echo get($row, "quantity")?></a>
                        <a class="itemCell" style="width: 100px"><?php echo get($row, "total"); $total = $total + get($row, "total");?></a>
                        <form method="post" class="editQuantity" style="height: 35px">
                            <input type="number" name="cartId" value="<?php echo get($row, "id")?>" hidden>
                            <input type="number" name="quantity" value="<?php echo get($row, "quantity")?>" min="1" style="width: 30%">
                            <input type="submit" id="subQuantityEdit" value="Edit quantity" style="width: 70%; padding: 3px; margin: 2px;">
                        </form>
                        <form method="post" class="editQuantity" style="height: 35px">
                            <input type="number" name="cartId" value="<?php echo get($row, "id")?>" hidden>
                            <input type="number" name="quantity" value="0" hidden>
                            <input type="submit" id="removeItem" value="Remove item" style="width: 100%; padding: 3px; margin: 2px;">
                        </form>
                    </li>
            <?php endforeach;?>
                </ul>
            <?php
                echo "</br></br><div style='text-align: center'>Your total is " . $total . "</div>";
                ?>
                <form method="post" class="buy" style="border: none; margin: 0px auto auto">
                    <input type="number" name="userId" value="<?php echo $userId; ?>" hidden>
                    <input type="submit" value="Place order" id="buy" style="height: 40px; width: 100%; padding: 3px; margin: 2px">
                </form>
            <?php else:
                echo "<div>Your cart is empty, time to do some shopping!</div>";
            endif;
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        alert("You need to log in");
        header("Location: login.php");
    }?>