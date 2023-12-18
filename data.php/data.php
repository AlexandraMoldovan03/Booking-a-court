<!doctype html>
<html>
    <head>
    <title>Your bookings</title>
    </head>

    <h1>Your bookings</h1>

    <?php
    $connect =mysqli_connect('localhost','root','','tennis');

    $query='SELECT name,email FROM bookings';
    $result = mysqli_query($connect, $querry);

    echo mysqli_num_rows($result);
    while($record = mysqli_fetch_assoc($result))
    {
        echo '<pre>';
        print_r($record);
        echo '</pre>';

        echo '<h2>'.$record['name'].'</h2>';
        echo '<div style="width:300px; height:40px; background-color: '.$record['rgb'].';"</div>';
    }