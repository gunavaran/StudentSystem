<?php

$notiquery="SELECT * FROM notify_marks WHERE StudentID=$username";
if ($notiquery_run=mysqli_query($link,$notiquery)){
    if (mysqli_num_rows($notiquery_run) != NULL) {
        while ($notiquery_row = mysqli_fetch_assoc($notiquery_run)) {
            $subject = $notiquery_row['Subject'];
            echo  'You have got poor marks for ' . $subject . ' in the last term examination.' . '<br/>';
            $delquery="DELETE FROM notify_marks WHERE StudentID=$username AND Subject='$subject'";
            $delquery_run=mysqli_query($link,$delquery);
        }
    }
}


