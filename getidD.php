<?php
$conn = mysqli_connect("localhost", "root", "", "assia");
if(isset($_POST['id'])){
$var=$_POST['id'];
if($var!='default'){
    $sql2="SELECT * FROM department WHERE idF = '$var' ";
    $reslta = mysqli_query($conn , $sql2);
    $select='<select class="select" name="idD" >
    <option value="" disabled selected>Department</option>';
    foreach($reslta as $row):
        $select.='<option value=" '.$row['idD'].'">'.$row['nameD'].'</option>';
    endforeach;
    $select.='</select>';
    echo  $select ;
}
}

?>
