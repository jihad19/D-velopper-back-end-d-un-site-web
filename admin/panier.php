<?php ob_start(); ?>
<?php include "header.php" ?>
<?php include('navbar.php'); ?>
<?php include "../includes/db.inc.php"?>

<?php 
    //getting the session id
    if (isset($_SESSION['id'])) {
        $client_id = $_SESSION['id'];
    }
    //getting the item id
    if (isset($_GET['item'])) {
        $item_id = $_GET['item'];
        //getting all items from cart table
    $panier_query = "SELECT * FROM cart WHERE item_id = $item_id AND client_id = $client_id";
    $panier_search_query = mysqli_query($conn,$panier_query);
    if (!$panier_search_query) {
        die("QUERY FAILED" . mysqli_error($conn));
    }
    while ($row = mysqli_fetch_array($panier_search_query)) {
        $item_title = $row['item_title'];
        $item_image = $row['item_image'];
        $item_price = $row['item_price'];
        $item_quantity = $row['item_quantity'];
    }
    $row_count = mysqli_num_rows($panier_search_query);

    if($row_count > 0){
        $update_query = "UPDATE cart SET item_quantity = item_quantity+1 WHERE item_id = $item_id AND client_id = $client_id";
        $update_item_query = mysqli_query($conn,$update_query);
        header('Location: panier.php');

    }else{
         //getting the item infos from products table
        $item_query = "SELECT * FROM product WHERE product_id = $item_id";
        $item_search_query = mysqli_query($conn,$item_query);

        while ($row = mysqli_fetch_array($item_search_query)) {
            $item_title = $row['product_title'];
            $item_image = $row['product_image'];
            $item_price = $row['product_price'];
            
        }

        if (!$item_search_query) {
            die("QUERY FAILED" . mysqli_error($conn));
        }

         //adding the item to cart if it doesn't already exist
        $add_query = "INSERT INTO cart(client_id,item_id,item_title,item_image,item_price) VALUES ($client_id,$item_id,'$item_title','$item_image',$item_price)";
        $add_to_panier_query = mysqli_query($conn,$add_query);

        if (!$add_to_panier_query) {
            die("QUERY FAILED" . mysqli_error($conn));
        }

        header('Location: panier.php');
    }
    }
        

   

      

?>



<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                panier
            </h1>
            
        </div>
    </div>
    <!-- /.row -->
    <table class="table table-bordered table-hover">
    <thead>
        <tr>
    
            <th>Id</th>
            <th>Title</th>                       
            <th>Image</th>
            <th>Price</th>
            <th>Remove</th>
        </tr>
    </thead>
    
          <tbody>
          <?php 
                
                $panier_query = "SELECT * FROM cart WHERE client_id = $client_id";
                $panier_search_query = mysqli_query($conn,$panier_query);
                while ($row = mysqli_fetch_array($panier_search_query)) {
                    
                    $panier_id = $row['item_id'];
                    $item_title = $row['item_title'];
                    $item_image = $row['item_image'];
                    $item_price = $row['item_price'];
                    $item_quantity = $row['item_quantity'];

                    $total = $item_price * $item_quantity;

                    echo "<tr>";
                    echo "<td>$panier_id</td>";
                    echo "<td>$item_title</td>";
                    echo "<td><img class= 'img-responsive' src='../img/$item_image' alt=''></td>";
                    echo "<td>$item_price</td>";
                    echo "<td><a href='panier.php?remove=$panier_id&user=$client_id'>Remove</a></td>";
                    echo "</tr>";

                }

                    
                if (isset($_GET['remove'])) {
                    $removed_item_id = $_GET['remove'];

                    $remove_query = "DELETE FROM panier WHERE item_id = $removed_item_id AND client_id = $client_id";
                    $removed_item_query = mysqli_query($conn,$remove_query);

                    header('Location: panier.php');
                }
            ?>

          </tbody>
</table>
<a href = "#" class="btn btn-warning btn-lg" data-dismiss="modal">Confirmer l'achat</a>

</form>

</div>
<!-- /.container-fluid -->



<?php include "footer.php" ?>