<?php

include('config/db_connect.php');

    //check get request id parameter
   if(isset($_GET['id'])){

        $id = mysqli_real_escape_string($conn,$_GET['id']); //prevent sql injection
        $sql = "SELECT * FROM pizzas WHERE id=$id";

        $results = mysqli_query($conn, $sql);
        
        $pizza = mysqli_fetch_assoc($results);


        mysqli_close($conn);

   }
   
   if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn,$_POST['id_to_delete']);


    
    
    $sql = "DELETE from pizzas WHERE id=$id_to_delete";

    if(mysqli_query($conn, $sql)){
        header('location: index.php');
    }else{
        echo 'query error :'. mysqli_error($conn);
    }
    

   }
    


?>

<!DOCTYPE html>
<html>
    <?php include('template/header.php') ?>
    <div class="container center">
        <?php if($pizza): ?>
            <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
            <p><?php echo htmlspecialchars($pizza['created_at']);?></p>
            <p><?php echo date($pizza['created_at']);?></p>
            <h5>Ingridients</h5>
            <ul>
                <?php foreach(explode(',',$pizza['ingridients']) as $ingridient):?>
                    <li><?php echo htmlspecialchars($ingridient)?></li>
                <?php endforeach?>
            </ul>

            <form action="details.php" method="POST">
                <input name="id_to_delete" type="hidden" value="<?php echo htmlspecialchars($pizza['id']) ?>"/>
                <input class="btn brand z-depth-0" name="delete" value="delete" type="submit">
            </form>
        <?php else: ?>
            <h5>no such pizza exist</h5>
        <?php endif ?>
    </div>
    

    <?php include('template/footer.php') ?>
</html>