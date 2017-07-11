<html>
<head>

    <title> Attendance </title>
    <link rel="stylesheet" type = "text/css" href = "../Styles/stylesheets.css"/>
    <style>
        nav[id=competition]{
            background-color: mediumorchid;
            height:60px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>

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
        <div id="content_area">
            <?php
            include '../Connect/Connect.php';
            session_start();
            $username = $_SESSION['username'];
            $query = "SELECT Role FROM users WHERE username = '$username'";
            $query_run = mysqli_query($link,$query);
            $query_row = mysqli_fetch_assoc($query_run);
            $role = $query_row['Role'];
            if ($role != 'student') {
                ?>
                <nav id="term_marks_navigation">
                    <ul id="nav">
                        <li><a href="../Attendance/enter_attendance.php"> Enter Attendance </a> </li>
                    </ul>
                </nav>
                <nav id="pilot_marks_navigation">
                    <ul id="nav">
                        <li> <a href="../Attendance/updateattendance.php">Update Attendance</a></li>
                    </ul>
                </nav>
                <?php
            } else{
                $attendance_query = "SELECT Attendance, Date FROM attendance WHERE StudentID = '$username'";
                $attendance_query_run = mysqli_query($link, $attendance_query);
                echo 'You are absent on: <br/>';
                $count = 0;
                while($attendance_row = mysqli_fetch_assoc($attendance_query_run)){
                    $attendance = $attendance_row['Attendance'];
                    $date = $attendance_row['Date'];
                    if (strtoupper($attendance)=='A'){
                        echo $date.'<br/>';
                        $count++;
                    }
                }
                if ($count == 0){
                    echo 'You are always present. Keep it up!!!';
                }

            }
            ?>


        </div>
    </div>

    <div id="sidebar">
        <nav id="competition">
            <ul id="nav">
                <li id = 'compLine' style="font-size: 20px; margin-top: 15px; margin-bottom: 0px"> <a href="../compDetail.php">Competition Details</a></li>
            </ul>
        </nav>

        <nav id="competition" style="margin-top: 0px; padding-top: 0px">
            <ul id="nav" style="margin-top: 0px">
                <li id = 'compLine' style="font-size: 20px; margin-top: 15px; margin-left: 20px"> <a href="../Calendar.php">School Calendar</a></li>
            </ul>
        </nav>

        <?php
        if ($username == 'principal'){
            ?>

            <nav id="competition" style="margin-top: 0px; padding-top: 0px">
                <ul id="nav" style="margin-top: 0px">
                    <li id = 'compLine' style="font-size: 20px; margin-top: 15px; margin-left: 45px"> <a href="../User/addStaff.php">Add Staff</a></li>
                </ul>
            </nav>

            <?php
        }
        ?>


    </div>

    <?php
    include '../Styles/FooterStyle.html';
    ?>
</div>
</body>
</html>