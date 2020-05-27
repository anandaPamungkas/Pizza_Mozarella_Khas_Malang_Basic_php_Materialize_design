<?php

include('config/db_connect.php');

    /*
    if(isset($_GET['submit'])){
        echo $_GET['email'];
        echo $_GET['title'];
        echo $_GET['ingridients'];
    }
    */

    //XSS (Cross Site Scripting) this is XSS script ecample that can be used to fill the input form
    //<script>window.location="https://materializecss.com/getting-started.html"</script>

    $email = "";
    $title = "";
    $ingridients = "";

    $errors = array('email'=>'', 'title'=>'', 'ingridients'=>'');

    if(isset($_POST['submit'])){ //iseet check if there is something in $_POST variable
        //echo htmlspecialchars($_POST['email']); //htmlspecialchars function to prevent XSS
        //echo htmlspecialchars($_POST['title']);
        //echo htmlspecialchars($_POST['ingridients']);
        
        //check email
        if(empty($_POST['email'])){
            $errors['email'] =  'An email is required <br/>';
        }
        else{
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //check if input is not a valid email
            
                $errors['email'] = 'invalid email address';
            
            }
        }

        if(empty($_POST['title'])){
            $errors['title'] =  'An title is required';
        }
        else{
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){ //preg_match using regex (regular expression) to check if title written in any kind of pattern
                $errors['title'] =  'title must be letters and spaces only';
            }
        }

        if(empty($_POST['ingridients'])){
            $errors['ingridients'] = 'An ingridient is required <br/>';
        }
        else{
            $ingridients = $_POST['ingridients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingridients)){ //preg_match using regex (regular expression) to check if ingridinets using comma seprated list
                $errors['ingridients'] =  'Ingridients must be comma separated list';
            }
        }//end of post check
    }

    if(array_filter($errors)){ //check if theres no input form error 
       // echo 'there are erros in the form';
    }else{
        //header('Location: index.php'); //if theres no error riderct to index
        //echo 'form is valid';

        //mysqli_real_escape_string prevent sql injection from form input
        if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingridients = mysqli_real_escape_string($conn, $_POST['ingridients']);
    
        //create sql
        $sql = "INSERT INTO pizzas(email,title,ingridients) VALUES('$email','$title','$ingridients')";

        //
        if(mysqli_query($conn, $sql)){
            header('location:index.php');
        }else{
            echo 'query error : '. mysqli_error($conn);
        }
    }

    }


?>

<!DOCTYPE html>
<html>
    <?php include('template/header.php') ?>
    
    <section class="container grey-text">
        <h4 class="ceneter">Add a pizza</h4>
        <form class="white" action="add.php" method="POST">
            <label>Your email</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>"/>
                <div class=red-text>
                    <?php echo $errors['email']; ?>    
                </div>
            <label>Pizza Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>"/>
            <div class=red-text>
                    <?php echo $errors['title']; ?>    
                </div>
            <label>Ingridients (comma separated):</label>
            <input type="text" name="ingridients" value="<?php echo htmlspecialchars($ingridients) ?>"/>
            <div class=red-text>
                    <?php echo $errors['ingridients']; ?>    
                </div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0"/>
            </div>
           
        </form>
</section>

    <?php include('template/footer.php') ?>
</html>