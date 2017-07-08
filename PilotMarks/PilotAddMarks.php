<!DOCTYPE html>

<html>
<head>

    <title>Add Pilot Marks</title>
    <link rel="stylesheet" type = "text/css" href = "../Styles/stylesheets.css"/>

</head>
<body>
<div id="wrapper">
    <div id="banner"></div>

    <nav id="navigation">
        <ul id="nav">
            <li><a href="../Templates/index.php"> Home </a> </li>
            <li> <a href="../Templates/ProfileTemplate.php">Profile</a></li>
            <li> <a href="../Templates/MarksTemplate.php">Marks</a></li>
            <li> <a href="../Templates/attendancetemplate.php">Attendance</a></li>
            <li> <a href="../Log_in_out/logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="content_area">
        <form action="PilotAddMarks.php" method="get">
            <fieldset>
                Year: <br>
                <input type="text" name="year" placeholder="Year" value="<?php if (isset($_GET['year'])){echo $_GET['year'];} ?>"><br><br>
                Serial No: <br>
                <input type="text" name="serial_no" placeholder="Serial No." value="<?php if (isset($_GET['serial_no'])){echo $_GET['serial_no'];} ?>"><br><br>
                Student ID:<br>
                <input type="text" name="id" placeholder="Student ID"><br><br>
                Part 1:<br>
                <input type="text" name="part1" placeholder="Part-1"><br><br>
                Part 2:<br>
                <input type="text" name="part2" placeholder="Part-2"><br><br>
                <input type="submit" value="Submit"><br><br>

            </fieldset><br>

                <?php
                include '../Connect/Connect.php';

                $error=0;
                if (isset($_GET['serial_no']) AND isset($_GET['id']) AND isset($_GET['part1']) AND isset($_GET['part2']) AND isset($_GET['year'])){
                    if(!empty($_GET['serial_no']) AND !empty($_GET['id']) AND !empty($_GET['part1']) AND !empty($_GET['part2']) AND !empty($_GET['year'])){
                        if($_GET['year'] !== (string)(int) $_GET['year']) {
                            $error++;
                            echo 'Year can only be number'.'<br>';
                        }else if((int)$_GET['year']<1990 OR (int)$_GET['year']>date("Y")){
                            $error++;
                            echo 'Year should be in range 1991-'.date('Y').'<br>';
                        }else{
                            $year=(int)$_GET['year'];
                        }

                        if($_GET['serial_no'] !== (string)(int) $_GET['serial_no']) {
                            $error++;
                            echo 'Serial Number should be a positive number'.'<br>';
                        }else {
                            $serial = (int)$_GET['serial_no'];
                        }

                        if($_GET['id'] !== (string)(int) $_GET['id'] OR strlen($_GET['id'])!=6) {
                            $error++;
                            echo 'Invalid format of Student ID'.'<br>';
                        }else{
                            $id=(int)$_GET['id'];
                        }

                        if($_GET['part1'] !== (string)(int) $_GET['part1']) {
                            $error++;
                            echo 'Part-1 marks should be an integer'.'<br>';
                        }else {
                            $part1 = (int)$_GET['part1'];
                            if ($part1 > 100 OR $part1 < 0) {
                                $error++;
                                echo "Part-1 marks should be in range 0 - 100".'<br>';
                            }
                        }

                        if($_GET['part2'] !== (string)(int) $_GET['part2']) {
                            $error++;
                            echo 'Part-2 marks should be an integer'.'<br>';
                        }else {
                            $part2 = (int)$_GET['part2'];
                            if ($part2 > 100 OR $part2 < 0) {
                                $error++;
                                echo "Part-2 marks should be in range 0 - 100".'<br>';
                            }
                        }

                        if($error==0) {
                            $s = "INSERT INTO pilot_marks(ID,Serial_no,Year,Part_1,Part_2) VALUES ($id,$serial,$year,$part1,$part2)";
                            if (mysqli_query($link, $s)) {
                                echo "Marks updated";
                            } else {
                                echo "Marks not updated";
                            }
                        }
                    } else {
                        echo 'None of the fields can take an empty value';
                    }

                } else {
                    echo 'All the required fields should be filled';
                }
                ?>
        </form>
    </div>

    <div id="sidebar">

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

    </footer>

</div>
</body>
</html>

