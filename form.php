<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    </head>

    <body>
        <?php  
            include ('dbcon.php');
            session_start();
            $classession = "";
            if(isset($_SESSION["class"])) { $classession = $_SESSION["class"]; }
            $_SESSION['class'] = $classession;
        ?>
        <script>
            $(document).ready(function(){ 

                //show data panel function 
                $('.datapanel').on('click',function(){
                    var panelId = $(this).attr('data-panelId');
                    
                    $('.choose').fadeToggle();
                    $('.input').fadeToggle();
                    $('#'+panelId).fadeToggle();
                    
                    if('#'+panelId == '#panelclass')  
                        $('#input-title').text("New Class Data");
                    else if('#'+panelId == '#panellecturer')
                        $('#input-title').text("New Lecturer Data");
                    else if('#'+panelId == '#panelsubject') 
                        $('#input-title').text("New Subject Data");
                    else if('#'+panelId == '#panelschedule') 
                        $('#input-title').text("New Schedule Data");
                });


                //close form function
                $('.close').on('click',function(){
                    var closeId = $(this).attr('close-id');

                    if(closeId == 'panelchoose') 
                        $('.choose').fadeToggle();
                    else if (closeId == 'panelinput') {
                        $('.input').toggle();
                        $('.input').find(".finput").css("display","none");
                    }
                    else if (closeId == 'panelasg') 
                        $('.asg').fadeToggle();
                    else if (closeId == 'panelschclass') 
                        $('.schclass').fadeToggle();
                    else if (closeId == 'paneladmin') {
                        $('.admin').fadeToggle();
                        $('#username').val("");
                        $('#password').val("");
                    }
                        

                    $('.form-container').fadeToggle();
                });

                $('.back').on('click',function(){
                    $('.input').toggle();
                    $('.input').find(".finput").css("display","none");
                    $('.choose').fadeToggle();
                });

                //ajax autocomplete search
                load_data();
                function load_data(query) {
                    $.ajax ({
                        url:"Process/fetchclass.php",
                        method:"POST",
                        data: { query: query },
                        success: function(data) {
                            $('#search-container').html(data);
                        }
                    });
                }
                $('#search_text').keyup(function() {
                    var search = $(this).val();
                    if(search != ' ') {
                        load_data(search);
                    }else {
                        load_data();
                    }
                });
                //end of ajax autocomplete
            });
        </script>

        <style>
            .form-container {
                display:none;
                position:fixed;
                z-index:10;
                left:0;
                right:0;
                top:0;
                bottom:0;
                margin:auto;
                text-align: center;

                width:100%;
                height:100%;

                background: rgba(0, 0, 0, 0.65);
            }

            .form {
                position:fixed;
                z-index:101;

                left:0;
                right:0;
                top:0;
                bottom:0;
                margin:auto;

                background: rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 15px 0 rgba(23, 24, 36, 0.4);
                backdrop-filter: blur( 4px );
                -webkit-backdrop-filter: blur( 4px );
                border-radius: 10px;
                border: 1px solid rgba( 255, 255, 255, 0.18 );
                animation:content-trans 0.5s ease;
            }
                .form .close{
                    color:white;
                    cursor:pointer;
                    float:right;
                    padding-right:0px;
                    margin-top: -10px;
                    margin-right:-8px;
                    font-size: 28px;
                    font-weight: bold;
                    transition:.25s ease;
                }

                .form .close:hover{
                    color:#505050;
                    transform: rotate(180deg);
                }

                .form .back {
                    color:white;
                    cursor:pointer;
                    float:left;
                    padding-right:0px;
                    margin-top: -10px;
                    margin-right:-10px;
                    font-size: 28px;
                    font-weight: bold;
                    transition:.25s ease;
                }
                .form .back:hover {
                    color:#505050;
                    animation: backanim .6s;
                    animation-iteration-count: infinite;
                }

                @keyframes backanim {
                    0% { transform:translateX(-0px) }
                    50% {transform:translateX(-5px)}
                    100% { transform:translateX(0px) }
                }

            
            .schclass {
                display:none;

                height: fit-content;
                width: clamp(300px, 20vw, 480px);
                padding-bottom:25px;
                padding-top:20px;
                padding-left:20px;
                padding-right:30px;
                justify-content: center;
            }

            .search-input input[type="text"] {
                width: 65%;
                padding:10px;
                margin-top:20px;
                margin-right:5px;
                margin-left:0px;
                font-size: 15px;
                border-radius:2px;
                border:none;
                transition:.2s ease;
                border-bottom:0px solid #363636;
                outline:none;
                text-align: center;
            }

                #search-container {
                    margin-top:20px;
                    height:30vh;
                    justify-content: center;
                    overflow-y:scroll;
                }

                .searchdata {
                    margin-top:15px;
                    margin-bottom:15px;
                    background:white;
                    width:fit-content;
                    padding-left:75px;
                    padding-right:75px;
                    padding-top:5px;
                    padding-bottom:5px;
                    margin-right:auto;
                    margin-left:auto;
                    cursor:pointer;

                    background: rgba(255, 255, 255, 0.9);
                    box-shadow: 0 8px 15px 0 rgba(23, 24, 36, 0.4);
                    backdrop-filter: blur( 4px );
                    -webkit-backdrop-filter: blur( 4px );
                    border-radius: 5px;
                    border: 1px solid rgba( 255, 255, 255, 0.18 );
                }
                a { text-decoration:none; color:inherit;}
                .searchdata p { margin:0;}

            .admin {
                display:none;

                height: fit-content;
                width: clamp(300px, 60vw, 480px);
                padding-bottom:25px;
                padding-top:20px;
                padding-left:20px;
                padding-right:30px;
            }

                .admin i {
                    position:absolute;
                    margin-top:30px;
                    margin-left:-40px;
                    cursor: pointer;
                }
            
            .asg {
                display:none;

                height: fit-content;
                width: clamp(400px, 65vw, 480px);
                padding-bottom:25px;
                padding-top:20px;
                padding-left:20px;
                padding-right:30px;
            }
            
            .asg .assessmentcontent {
                display:grid;
                grid-template-columns:1fr 1fr;
                grid-template-rows:1fr 1fr 1fr;
            }
            .asg .at {
                grid-row-start:1;
                grid-row-end:span 3;
            } 
            
            .asg label {
                float:right;
                display:block;
                color:white;
                font-family:bahnschrift;
                font-size:15px;
                margin-top:20px;
                margin-bottom:8px;
            }
            .asg select {
                float:right;
                width:70%;
                font-size:15px;
                padding-bottom:5px;
                padding-top:5px;
                padding-left:10px;
                padding-right:30px;
                border:1px solid #8292a2;
                border-radius:0.25rem;
                cursor:pointer;
                overflow:scroll;
            }

            .asg textarea {
                resize:none;
                width: 100%;
                height:85%;
                padding:10px;
                margin-top:20px;
                margin-right:5px;
                font-size: 15px;
                border-radius:2px;
                border:none;
                transition:.2s ease;
                border-bottom:0px solid #363636;
                outline:none;
            }
            .asg textarea:hover {box-shadow:0px 2px 10px #363636b9;}

            .asg input[type="submit"]{
                float:right;
                width: 70%;
                background:white;
                border:1px solid #8292a2;
                border-radius:0.25rem;
                padding:10px;
                margin-top:20px;
                border:none;
                font-size: 15px;
                transition:.25s ease;
                outline:none;
                cursor:pointer;
            }
            .asg input[type="submit"]:hover{
                background:#505050;
                color:white;
            }

            /* start of date design */
            input[type="date"] {
                float:right;
                width:fit-content;
                display:block;
                position:relative;
                padding-bottom:15px;
                padding-top:10px;
                padding-left:20px;
                padding-right:30px;
                margin-left:auto;
                margin-right:auto;
                
                font-size:1rem;
                font-family:monospace;
                
                border:1px solid #8292a2;
                border-radius:0.25rem;
                background:
                    white
                    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='15' height='17' viewBox='0 0 20 22'%3E%3Cg fill='none' fill-rule='evenodd' stroke='%23688EBB' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' transform='translate(1 1)'%3E%3Crect width='18' height='18' y='2' rx='2'/%3E%3Cpath d='M13 0L13 4M5 0L5 4M0 8L18 8'/%3E%3C/g%3E%3C/svg%3E")
                    right 1rem
                    center
                    no-repeat;
                
                cursor:pointer;
            }
            input[type="date"]:focus {
                outline:none;
                border-color:#3acfff;
                box-shadow:0 0 0 0.25rem rgba(0, 120, 250, 0.1);
            }

            .ad ::-webkit-datetime-edit {}
            .ad ::-webkit-datetime-edit-fields-wrapper {}
            .ad ::-webkit-datetime-edit-month-field:hover,
            .ad ::-webkit-datetime-edit-day-field:hover,
            .ad ::-webkit-datetime-edit-year-field:hover {
                background:rgba(0, 120, 250, 0.1);
            }
            .ad ::-webkit-datetime-edit-text {
                opacity:0;
            }
            .ad ::-webkit-clear-button,
            .ad::-webkit-inner-spin-button {
                display:none;
            }
            .ad ::-webkit-calendar-picker-indicator {
                position:absolute;
                width:2.5rem;
                height:100%;
                top:0;
                right:0;
                bottom:0;
                
                opacity:0;
                cursor:pointer;
                
                color:rgba(0, 120, 250, 1);
                background:rgba(0, 120, 250, 1);
            }

            .ad input[type="date"]:hover::-webkit-calendar-picker-indicator { opacity:0.05; }
            .ad input[type="date"]:hover::-webkit-calendar-picker-indicator:hover { opacity:0.15; }
            /* end of date design */

            .input {
                display:none;

                height: fit-content;
                width: clamp(300px, 60vw, 480px);
                padding-bottom:25px;
                padding-top:20px;
                padding-left:20px;
                padding-right:30px;
            }
                .input #input-title, .admin #admintitle, .asg #asgtitle{
                    width:300px;
                    margin-left:15px;
                    font-size:18px;
                    font-family:bahnschrift;
                    color:white;
                }

            .choose {
                display:none;

                height: clamp(300px, 25vh, 480px);
                width: clamp(300px, 60vw, 480px);
                padding-bottom:20px;
                padding-top:20px;
                padding-left:20px;
                padding-right:30px;
            }

            .choosedata {
                display:grid;
                grid-auto-flow: row;
                grid-gap:22px;
                margin-top:10px;
                justify-content: center;
                animation:content-trans 0.5s ease;
            }

            .choosedata span {
                width:300px;
                margin-left:15px;
                margin-top:5px;
                font-size:18px;
                font-family:bahnschrift;
                background:#fbff0a;
            }
            
            .choosedata button {
                border-radius:5px;
                outline:none;
                padding-top:10px;
                padding-bottom:10px;
                padding-left:20px;
                padding-right:20px;
                margin-left:15px;
                width:300px;
                font-size:15px;

                cursor:pointer;
                transition:ease 0.2s;

                background: rgba(248, 248, 248,0.8);
                box-shadow: 0 8px 15px 0 rgba(23, 24, 36, 0.4);
                backdrop-filter: blur( 4px );
                -webkit-backdrop-filter: blur( 4px );
                border: 1px solid rgba( 255, 255, 255, 0.18 );
            }
                .choosedata button:hover {
                    background:rgba(248, 248, 248,1);
                    transition:ease-out 0.2s;
                    box-shadow: 0 8px 10px -5px #585858;
                    transform: translateY(-0.25em);
                }

            .forminput {
                display:block;
            }
            .finput {
                display:none;
                padding-left:20px;
            }
                .factive {
                    display:block;
                }

                .finput input[type="text"], .admin input[type="text"], .admin input[type="password"]{
                    width: 60%;
                    padding:10px;
                    margin-top:20px;
                    margin-right:5px;
                    font-size: 15px;
                    border-radius:2px;
                    border:none;
                    transition:.2s ease;
                    border-bottom:0px solid #363636;
                    outline:none;
                    text-align: center;
                }
                .finput input[type="text"]:hover, .admin input[type="text"]:hover {
                    box-shadow:0px 2px 10px #363636b9;
                }
                
                .finput input[type="submit"],  .admin input[type="submit"]{
                    width: fit-content;
                    background:white;
                    padding:10px;
                    margin-top:20px;
                    border:none;
                    font-size: 15px;
                    transition:.25s ease;
                    outline:none;
                    cursor:pointer;
                }

                .finput input[type="submit"]:hover {
                    background:#505050;
                    color:white;
                }

                .finput select {
                    width: 64%;
                    padding:10px;
                    margin-top:20px;
                    margin-right:5px;
                    font-size: 15px;
                    border-radius:2px;
                    border:none;
                    transition:.2s ease;
                    border-bottom:0px solid #363636;
                    outline:none;
                    text-align: center;
                    cursor:pointer;
                }

                #tstart,#tend {
                    margin-top:40px;
                    width:fit-content;
                }
                #tstart::before {
                    position:absolute;
                    content: 'Time Start';
                    color:white;
                    font-family:bahnschrift;
                    margin-top:-55px;
                    margin-left:12px;
                }
                #tend::before {
                    position:absolute;
                    content: 'Time End';
                    color:white;
                    font-family:bahnschrift;
                    margin-top:-55px;
                    margin-left:12px;
                }

                .finput input[type="time"] {
                    width: 20%;
                    padding:5px;
                    margin-right:5px;
                    font-size: 15px;
                    border-radius:2px;
                    border:none;
                    transition:.2s ease;
                    border-bottom:0px solid #363636;
                    outline:none;
                    text-align: center;
                }

            @keyframes content-trans {
                0% { opacity: 0;}
            }

        </style>
        <div class = "form-container">
            <div class = "form schclass">
                <span class="close" close-id = "panelschclass">&times;</span>
                <div class="search-input">
                    <input type="text" id = "search_text" placeholder="Type to search the class..">
                </div>
                <div id = "search-container">
                </div>
            </div>

            <!-- change to admin form -->
            <div class = "form admin">
                <span class="close" close-id = "paneladmin">&times;</span>
                <span id = "admintitle">Admin Sign-In</span>
                <br>
                <form method = "POST" action = "Process/formprocess.php">
                    <input type = "text" id ="username" placeholder="Enter username..." name = "username" required>
                    <input type = "password" id ="password" placeholder="Enter password..." name = "password" required>
                    <br>
                    <input type = "submit" value = "Submit" name = "btn_loginuser">
                </form>
            </div>

            <!-- select class form -->
            <div class = "form choose">
                <span class="close" close-id = "panelchoose">&times;</span>
                <div class = "choosedata">
                    <span>Which data do you want to add?</span>
                    <button class = "datapanel" data-panelid = "panelclass">Class</button>
                    <button class = "datapanel" data-panelid = "panellecturer">Lecturer</button>
                    <button class = "datapanel" data-panelid = "panelsubject">Subject</button>
                    <button class = "datapanel" data-panelid = "panelschedule">Schedule</button>
                </div>
            </div>

            <!-- assessment form -->
            <div class = "form asg">
                <span class="close" close-id = "panelasg">&times;</span>
                <span id = "asgtitle">New Assessment Details</span>
                <br>
                <form method = "POST" action = "Process/formprocess.php">
                    <div class = "assessmentcontent">
                        <div class = "at">
                            <textarea maxlength = "200" name = "assdetails">Enter assessment details...</textarea>
                        </div>
                        <div class = "ad">
                            <label>Assessment Deadline</label>
                            <input type="date" name = "assdeadline" required>
                        </div>
                        
                        <div class = "as">
                            <label>Assessment Subject</label>
                            <select name = "asssubject" required>
                                <option selected disabled>Choose subject</option>
                                <?php 
                                    include ('dbcon.php');
                                    $query = "SELECT S.* FROM subject S WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description = CONCAT(S.Subject_Code, ' ', S.Subject_Name) AND NOT Status_ID = '2')";
                                    $result = mysqli_query ($db, $query);
                                    while ($row = mysqli_fetch_array($result)):;
                                ?>
                                <option value="<?=$row['Subject_Code'] ?>"><?=$row['Subject_Code'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class = "ab">
                            <input type = "submit" value = "Submit" name = "btn_assregister">
                        </div>
                    </div>
                </form>
            </div>

            <!-- new data form -->
            <div class = "form input">
                <span class="back">&laquo;</span>
                <span class="close" close-id = "panelinput">&times;</span>
                <span id = "input-title">New Data</span>
                <!-- class data -->
                <div class = "finput" id = "panelclass">
                    <form method = "POST" action = "Process/formprocess.php">
                        <input type = "text" placeholder="Enter class name..." name = "class_txt" required>
                        <input type = "submit" value = "Submit" name = "btn_classregister">
                    </form>
                </div>
                <!-- lecturer data -->
                <div class = "finput" id = "panellecturer">
                    <form method = "POST" action = "Process/formprocess.php">
                        <input type = "text" placeholder="Enter lecturer name..." name = "lecturer_txt" required>
                        <input type = "submit" value = "Submit" name = "btn_lecturerregister">
                    </form>
                </div>
                <!-- subject data -->
                <div class = "finput" id = "panelsubject">
                    <form method = "POST" action = "Process/formprocess.php">
                        <input type = "text" placeholder="Enter subject code..." name = "subjectcode_txt" required>
                        <input type = "text" placeholder="Enter subject name..." name = "subjectname_txt" required>
                        <br>
                        <input type = "submit" value = "Submit" name = "btn_subjectregister">
                    </form>
                </div>
                <!-- schedule data -->
                <div class = "finput" id = "panelschedule">
                    <form method = "POST" action = "Process/formprocess.php">
                        <input type="time" id = "tstart" name = "scheduletimestart" required>
                        <input type = "time" id = "tend" name = "scheduletimeend" required>
                        <br>
                        <input type = "text" placeholder="Enter schedule location..." name = "schedulelocation" required>

                        <select name = "scheduleday" required>
                            <option selected disabled>Schedule Day</option>
                            <option value = "Sunday">Sunday</option>
                            <option value = "Monday">Monday</option>
                            <option value = "Tuesday">Tuesday</option>
                            <option value = "Wednesday">Wednesday</option>
                            <option value = "Thursday">Thursday</option>
                            <option value = "Friday">Friday</option>
                            <option value = "Saturday">Saturday</option>
                        </select>
                        <br>
                        <select name = "schedulesubject" required>
                            <option selected disabled>Subject Code</option>
                            <?php 
                                include ('dbcon.php');
                                $query = "SELECT S.* FROM subject S WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description = CONCAT(S.Subject_Code, ' ', S.Subject_Name) AND NOT Status_ID = '2')";
                                $result = mysqli_query ($db, $query);
                                while ($row = mysqli_fetch_array($result)):;
                            ?>
                            <option value="<?=$row['Subject_Code'] ?>"><?=$row['Subject_Code'] ?></option>
                            <?php endwhile; ?>
                        </select>

                        <select name = "scheduleclass" required>
                            <option selected disabled>Class Name</option>
                            <?php 
                                $query = $query = "SELECT C.* FROM class C WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= C.Class_Name AND NOT Status_ID = '2')";
                                $result = mysqli_query ($db, $query);
                                while ($row = mysqli_fetch_array($result)):;
                            ?>
                            <option value="<?=$row['Class_ID'] ?>"><?=$row['Class_Name'] ?></option>
                            <?php endwhile; ?>
                        </select>

                        <select name = "schedulelecturer" required>
                            <option selected disabled>Lecturer Name</option>
                            <?php 
                                $query = $query = "SELECT L.* FROM lecturer L WHERE NOT EXISTS(SELECT 1 FROM request R WHERE R.Request_Description= L.Lecturer_Name AND NOT Status_ID = '2')";
                                $result = mysqli_query ($db, $query);
                                while ($row = mysqli_fetch_array($result)):;
                            ?>
                            <option value="<?=$row['Lecturer_ID'] ?>"><?=$row['Lecturer_Name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <input type = "submit" value = "Submit" name = "btn_scheduleregister">
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>