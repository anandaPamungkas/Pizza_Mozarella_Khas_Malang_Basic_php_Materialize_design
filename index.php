<?php

   include('config/db_connect.php');
   //write query
   $sql = 'SELECT title, ingridients, id FROM pizzas ORDER BY created_at';

   //make query and get results
   $results = mysqli_query($conn, $sql);

   //fetch the resulting rows
   $pizzas = mysqli_fetch_all($results, MYSQLI_ASSOC);

   //explode function let us make an array of data from abunch of data that seperated by something, 
  //in this case we eill make an array from data that separated by comma
   //print_r(explode(',', $pizzas[0]['ingridients'])); 
 

   //free results from memory
   //mysqli_free_result($results);

   //close the connection
   mysqli_close($conn);

 

?>

<!DOCTYPE html>
<html>
    <?php include('template/header.php') ?>
    
    
    
    <h4 class="center grey-text">Pizzas</h4>
    <div class="container">
        <div class="row">
            
            <?php foreach($results as $pizza):?>
            
                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <img src="pizza.svg" class="pizza">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                            <div>
                                <ul>
                                    <?php foreach(explode(',',$pizza['ingridients']) as $ingridient):?>
                                        <li>
                                            <?php echo htmlspecialchars($ingridient); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-action right-align">
                            <a class="brend.text" href="details.php?id=<?php echo $pizza['id'] ?>">more info</a>
                        </div>
                    </div>
                </div>
                
            <?php endforeach; ?>

         
        </div>
    </div>


    <?php include('template/footer.php') ?>
</html>