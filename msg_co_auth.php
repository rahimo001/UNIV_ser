
<?php
    if(isset($_SESSION['msg'])) :
?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert"  style="background-color:#e7cdc1;">
        <strong>Hey!</strong> <?= $_SESSION['msg']; ?>
<center><button type="button" style="background-color:; color:white;"  name="" > <a  class="btn btn-primary" style="background-color:black;"href="/memoire/login/journal/add_co.php"> Add Co-author</a></button></center>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>



<?php 
    unset($_SESSION['msg']);
    endif;
?>


