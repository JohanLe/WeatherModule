<?php 


?>

<div class="main-container-v2">

    <form class="basic-form" method="POST" action="weather/ipadress">
        <label>Enter an ip-adress</label>
        <input name="ipadress" type="text" required>
        <input type="submit" name="submit" value="Submit">
    
    </form>


    <form class="basic-form" method="POST" action="api-weather/documentation">
    <label>Api doc</label>
        <input type="submit" name="cords" value="Submit">
    </form>
    <?php if($data['msg']) :  ?>
    <p> <?= $data['msg'] ?> </p>

<?php endif; ?>
    </div>