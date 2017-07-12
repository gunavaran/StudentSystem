<?php
include "../Log_in_out/core.php";
if (logged_in()) {
?>
<!DOCTYPE html>

<html>
<head>

    <title>Update Pilot Marks</title>
    <link rel="stylesheet" type = "text/css" href = "../Styles/stylesheets.css"/>
    <?php
    include '../Styles/FormStyle.html';
    ?>
    <style>
        select{
            width: 100%;
            height: 30px;
            display: inline-block;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="banner"></div>

    <nav id="navigation">
        <ul id="nav">
            <li><a href="../Templates/index.php"> Home </a> </li>
            <li> <a href="#">Profile</a></li>
            <li> <a href="/Templates/MarksTemplate.php">Marks</a></li>
            <li> <a href="../Templates/attendancetemplate.php">Attendance</a></li>
            <li> <a href="/Log_in_out/logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="content_area">
        <form action="UpdatePilotMarks.php" method="get" name="fixedform">
            Year:<br>
            <input type="text" name="year"><br><br>
            Serial No:<br>
            <input type="text" name="serialnum"><br><br>
            Student ID:<br>
            <input type="text" name="indexnum"><br><br>
            Part:<br>
            <select name='part'>
                <option value="part1">Part-1</option>
                <option value="part2">Part-2</option>
            </select>
            <br><br>
            Marks:<br>
            <input type="text" name="marks"><br><br>
            <input type="submit" value="Submit"><br><br>



                <?php
                include '../Connect/Connect.php';

                $error=0;
                if (isset($_GET['serialnum']) AND isset($_GET['indexnum']) AND isset($_GET['year']) AND isset($_GET['marks']) ){
                    if(!empty($_GET['serialnum']) AND !empty($_GET['indexnum']) AND !empty($_GET['year']) AND !empty($_GET['marks'])){
                        if($_GET['serialnum'] !== (string)(int) $_GET['serialnum']) {
                            $error++;
                            echo 'Serial Number should be a positive number<br>';
                        }else {
                            $serial = (int)$_GET['serialnum'];
                        }

                        if($_GET['indexnum'] !== (string)(int) $_GET['indexnum'] OR strlen($_GET['indexnum'])!=6) {
                            $error++;
                            echo 'Invalid format of Student ID'.'<br>';
                        }else{
                            $indexnum=(int)$_GET['indexnum'];
                        }

                        if($_GET['year']!==(string)(int)$_GET['year'] OR strlen($_GET['year'])!=4){
                            $error++;
                            echo 'Invalid input for year';
                        }else{
                            $year=(int)$_GET['year'];
                        }
                        if($_GET['marks'] !== (string)(int) $_GET['marks']) {
                            $error++;
                            echo 'Marks should be an integer'.'<br>';
                        }else {
                            $marks = (int)$_GET['marks'];
                            if ($marks > 100 OR $marks < 0) {
                                $error++;
                                echo "Marks should be in range 0 to 100".'<br>';
                            }
                        }

                        if($error==0) {
                            $query_details = "SELECT * FROM student_details where StudentID = '$indexnum'";
                            $query_run_detail = mysqli_query($link, $query_details);
                            $query_row_detail = mysqli_fetch_assoc($query_run_detail);
                            $grade = $query_row_detail['Grade'];
                            $division = $query_row_detail['Division'];

                            $user =$_SESSION['username'];
                            $query_user = "SELECT grade , division FROM staffuser WHERE username = '$user'";
                            $query_user_run = mysqli_query($link, $query_user);
                            $query_user_row = mysqli_fetch_assoc($query_user_run);
                            $staff_grade = $query_user_row['grade'];
                            $staff_division = $query_user_row['division'];



                            if(($staff_grade != 'all' && $grade != $staff_grade) || ($staff_division != 'all' && $division != $staff_division)){
                                echo 'You are restricted to access the requested details...!';
                            }else {
                                $query = "SELECT * FROM pilot_marks WHERE StudentID = '$indexnum' AND  Year = '$year' AND SerialNumber ='$serial'";
                                $query_run = mysqli_query($link, $query);
                                if (mysqli_num_rows($query_run) == NULL) {
                                    echo "No such record is found";
                                } else {
                                    $part = $_GET['part'];
                                    if ($part == 'part1') {
                                        $query2 = "UPDATE pilot_marks SET Part1 = '$marks' WHERE StudentID = '$indexnum' AND  Year = '$year' AND SerialNumber ='$serial'";
                                        if ($query2_run = mysqli_query($link, $query2)) {
                                            echo 'Update Successful';
                                        } else {
                                            echo 'Update Failed';
                                        }
                                    } elseif ($part == 'part2') {
                                        $query2 = "UPDATE pilot_marks SET Part2 = '$marks' WHERE StudentID = '$indexnum' AND  Year = '$year' AND SerialNumber ='$serial'";
                                        if ($query2_run = mysqli_query($link, $query2)) {
                                            echo 'Update Successful';
                                        } else {
                                            echo 'Update Failed';
                                        }
                                    }

                                }
                            }
                        }
                    }else {
                        echo 'None of the fields can take an empty value';
                    }

                }else {
                    echo 'All the required fields should be filled';
                }
                ?>
</form>
</div>

    <div id="sidebar">
        <nav id="competition">
            <ul id="nav">
                <li id = 'compLine' style="font-size: 20px; margin-top: 15px; margin-bottom: 0px"> <a href="../Templates/CompDetailTemplate.php">Competition Details</a></li>
            </ul>
        </nav>

        <nav id="competition" style="margin-top: 0px; padding-top: 0px">
            <ul id="nav" style="margin-top: 0px">
                <li id = 'compLine' style="font-size: 20px; margin-top: 15px; margin-left: 20px"> <a href="../Calendar/Calendar.php">School Calendar</a></li>
            </ul>
        </nav>

        <?php
        $username = $_SESSION['username'];

        if ($username == 'principal'){
            ?>

            <nav id="competition" style="margin-top: 0px; padding-top: 0px">
                <ul id="nav" style="margin-top: 0px">
                    <li id = 'compLine' style="font-size: 20px; margin-top: 15px; margin-left: 45px"> <a href="../addStaff.php">Add Staff</a></li>
                </ul>
            </nav>

            <?php
        }
        ?>


    </div>

<footer>
    <div class = 'footer1'>
        <h3 id="h3">Address</h3>
        J/St.John Bosco Vidyalayam,<br/>
        Racca Road, Jaffna.
    </div>
    <div class = 'footer2'>
        <h3 id="h3" >Contact Us</h3>
        Email : stjohnbosco@yahoo.com<br />
        Tel: Principal office: +940212222540
    </div>
    <div class = 'footer3'><i>copyright : Futura Labs</i></div>

</div>
</body>
</html>
    <?php
} else {
    include '../Log_in_out/loginform.php';
}
