<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="noti.js"></script>

        <title>Homepage | Timetable Generator</title>
    </head>

    <body>
        <?php  
            include ('dbcon.php');
            session_start();
            $classession = "";
            if(isset($_GET["class"])) { $classession = $_GET["class"]; }
            $_SESSION['class'] = $classession;
        ?>

        <!-- navigation section -->
        <div id = "menu"></div>
        <div id = "form"></div>
        <script>
            $(document).ready(function(){ 
                var classsession = '<?php echo $classession; ?>';
                //get navigation menu
                $.get("nav.html", function(data) {
                    $("#menu").html(data);
                });

                //get form page
                $.get("form.php", function(data) {
                    $("#form").html(data);
                });

                //Initialize default array for schedule time
                var schedule = [];
                //get todays date and time
                updateClock();
                function updateClock() {
                    var today = new Date();
                    const monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUNE",
                    "JULY", "AUG", "September", "OCT", "NOV", "DEC"];

                    var time = today.getHours() + ":" + today.getMinutes();
                    var hours = today.getHours();
                    var minutes = today.getMinutes();
                    var seconds = today.getSeconds();
                    seconds = ("0" + seconds).slice(-2);
                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0'+minutes : minutes;
                    var strTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

                    var date = today.getDate() + ' ' + monthNames[today.getMonth()];
                    var datetime = strTime;
                    $('#today').text(datetime);
                    $('#datetoday').text(date);

                    if(classsession != "" && schedule[0] != undefined) shownotification(schedule);
                    setTimeout(updateClock, 1000);
                }

                //get todays day
                var today = new Date();
                var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                var dayname = days[today.getDay()];
                $('#daytext').text(dayname);
                
                var schedule = [];
                setTimeout(getscheduletime, 1000);
                
                function getscheduletime() {
                    var inputs = $(".subject");
                    for(var i = 0; i < inputs.length; i++)
                        schedule.push($(inputs[i]).attr('value'));
                };
                console.log(schedule);

                //change todays day name
                $('.arrowday').on('click',function() {
                    var daytext = $('#daytext').text();
                    var arrowid = $(this).attr('arrow-id');
                    var dayindex = days.indexOf(daytext);

                    if(arrowid == 'left') {
                        if(dayindex == 0) {
                            dayname = days[6];
                        }else {
                            dayname = days[dayindex-1];
                        }
                    }else if(arrowid == 'right') {
                        if(dayindex == 6) {
                            dayname = days[0];
                        }else {
                            dayname = days[dayindex+1];
                        }
                    }
                    $("#daytext").toggle();
                    $("#daytext").animate({width:'toggle'},350);
                    $("#daytext").text(dayname);
                    load_schedule(classsession,dayname);
                });

                //show and set classsession
                if(classsession != "") {
                    $('#selbutton').html(classsession);
                }
                //show form page
                $('.newdata').on('click',function() {
                    var contentId = $(this).attr('content-id');

                    var inputpass = prompt("Enter the password");
                    var output = load_password(inputpass);
                    if(output === "Found") {
                        if(contentId === 'schedulecontent') {
                            $('.form-container').fadeToggle();
                            $('.choose').fadeToggle();

                        }else if (contentId === 'assessmentcontent') {
                            if(classsession == "") {
                                alert("There are no class selected!");
                            }else {
                                $('.form-container').fadeToggle();
                                $('.asg').fadeToggle();
                            }
                        }

                    }else {
                        alert("Wrong password!");
                    }
                });

                //show select class
                $('.sel').on('click',function() {
                    $('.form-container').fadeToggle();
                    $('.schclass').fadeToggle();
                });

                //ajax enter class password
                function load_password(password) {
                    var result = "";
                    $.ajax ({
                        url:"Process/fetchpassword.php",
                        method:"POST",
                        async: false,
                        data: {password:password},
                        success: function(data) {
                            result = data;
                        }
                    });
                    return result;
                }

                if(classsession != "") { 
                    load_schedule(classsession, dayname); 
                    load_assessment(classsession); 
                    load_notes(classsession);
                }

                $('#savenotesbutton').on('click', function() {
                    if(classsession != "") { 
                        var text = $('textarea#notes-container').val();
                        save_notes(classsession, text);
                    }else {
                        alert("There is no class selected!");
                    }
                })
                
                //ajax load schedule
                function load_schedule(query, day) { 
                    $.ajax ({
                        url:"Process/fetchschedule.php",
                        method:"POST",
                        data: { query: query, day : day },
                        success: function(data) {
                            $('#schedule-container').html(data);
                        }
                    });
                }

                //ajax load assessment
                function load_assessment(query,day) { 
                    $.ajax ({
                        url:"Process/fetchassessment.php",
                        method:"POST",
                        data: { query: query},
                        success: function(data) {
                            $('#assessment-container').html(data);
                        }
                    });
                }

                //ajax load notes
                function load_notes(query) {
                    $.ajax ({
                        url:"Process/fetchnotes.php",
                        method:"POST",
                        data: { query: query },
                        success: function(data) {
                            if(!data) {
                                data = "this notes area can only have 500 characters"
                            }
                            $('#notes-container').html(data);
                        }
                    });
                }

                //ajax save notes
                function save_notes(query,text) {
                    $.ajax ({
                        url:"Process/savenotes.php",
                        method:"POST",
                        data: { query : query, text : text},
                        success: function(data) {
                            $('.savetooltip').fadeIn();
                            setTimeout(function() { $('.savetooltip').fadeOut(); }, 1000);
                        }
                    });
                }
            });
        </script>

        <!-- main content -->
        <style>
            @font-face{
                font-family: bahnschrift;
                src: url(Fonts/Bahnschrift/BAHNSCHRIFT.TTF);
            }

            body { margin:0; animation: content-trans .6s}
            body::-webkit-scrollbar-track
                {
                    box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                    border-radius: 10px;
                    background-color: #F5F5F5;
                    width:thin;
                }

                body::-webkit-scrollbar
                {
                    width: 8px;
                    background-color: #F5F5F5;
                }

                body::-webkit-scrollbar-thumb
                {
                    border-radius: 10px;
                    box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                    background-color: #555;
                    transition:.2s ease;
                }
                body::-webkit-scrollbar-thumb:hover
                {
                    background-color: rgb(146, 146, 146);
                }

            .main {
                background:rgb(255, 255, 255);

                display:grid;
                grid-template-rows: 1fr 4fr;
                
                height:100vh;
                margin-left:130px;
            }

            @media screen and (max-width: 900px) {
                .main { grid-template-rows:1fr; margin-left:20px;  margin-top:60px; padding-right:20px; overflow:visible;}
                #dateday p {
                    font-size:1.6rem;
                    margin-top:30px;
                    margin-bottom:65px;
                    position:relative;
                }
                .right {
                    margin-top:15px !important;
                }
                .content {
                    grid-template-rows:repeat(2,60vh) !important;
                    grid-template-rows:auto;
                }
                .schedule, .assessment {
                    height:85% !important;
                }
            }

            /* .header { background-color:pink;}
            .content { background-color:cyan;}  */

            .header {
                display:grid;
                grid-template-columns: 3fr 2fr;

                margin-top:10px;
            }
                #classset {
                    position:absolute;
                    margin-left:20px;
                }

                .right {
                    margin-right:2vw;
                    margin-top:10px;
                    text-align:right;
                }
                    #currentday h2{
                        font-family: bahnschrift;
                        font-size:clamp(20px, 3vw, 25px);

                        letter-spacing:1px;
                        margin-bottom:-15px;

                        display:inline-block;
                        background:#222222;
                        padding:10px 20px;
                        color:white;
                        border-radius:5px;
                    }
                    #currentday h2::before{ 
                        display:block;
                        content: 'clock';
                        position:absolute;
                        margin-top:-20px;
                        margin-left:4%;
                        font-size:10px;
                        background:crimson;
                        color:white;
                        padding:3px 10px;
                        border-radius:5px;
                    }
                    #currentday p {
                        color:crimson;
                        font-family:arial;
                        font-weight:bold;
                    }

                #title h2 {
                    font-family: bahnschrift;
                    font-size:30px;
                    color:#2c2c2c;

                    letter-spacing:1px;
                    margin-bottom:8px;
                }

                .sel {
                    width:200px;
                    background: #fff;
                    border-radius:4px;
                    color:black;
                    border:1px solid black;
                    text-align:left;
                    margin-bottom:1.7vh;
                    font-size:1.05rem;
                    font-family:arial;
                    padding:5px 15px 5px 15px;
                    outline:none;
                    transition:ease-out 0.3s;
                    box-shadow:inset 0 0 0 0 rgb(255, 99, 99);
                    cursor:pointer;
                }
                    .sel:hover,#dateday .arrowday:hover {
                        box-shadow:inset 200px 0 0 0 #fb7171;
                        border:1px solid #fb7171;
                        color:white;
                    }
                #dateday {
                    display:flex;
                    flex-basis:row;
                }
                    #dateday p {
                        font-family: arial;
                        color:rgb(2, 2, 2);
                        opacity:.75;
                        font-size:1.5rem;
                        letter-spacing:0.1vw;
                        margin-top:10px;
                        margin-bottom:50px;
                    }
                    #dateday .arrowday {
                        height:min-content;
                        padding-top:3px;
                        padding-bottom:3px;
                        padding-left:8px;
                        padding-right:8px;
                        margin-top:12px;
                        margin-right:8px;
                        border-radius:4px;
                        border:1px solid black;
                        background:white;
                        cursor:pointer;
                        transition:.2s ease;
                        color:black;
                        box-shadow:inset 0 0 0 0 rgb(255, 99, 99);
                    }


            .content {
                display:grid;
                height:70vh;
                grid-template-columns:repeat(auto-fit, minmax(320px,1fr));
                grid-template-rows:repeat(auto-fit, minmax(320px,1fr));
                grid-auto-rows: auto;
                grid-gap:2.2vw;
                /* animation:to-top .7s; */
            }
                .schedule, .assessment{
                    display:block;
                    background-color:#f6fafc;
                    box-shadow:inset 1px 2px 5px #072b4d1c;
                    padding:1.5vw;
                    padding-left:30px;
                    padding-right:30px;
                    overflow-y:scroll;
                }

                    .newdata {
                        content: '+ Add new data';
                        color:white;
                        font-weight:bold;
                        font-size:12px;
                        font-family:Arial, Helvetica, sans-serif;
                        background:#68ddd5;
                        border-radius:15px;
                        padding:8px 15px;
                        box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.15);
                        cursor:pointer;
                        margin-top:20px;
                        float:right;
                        border:none;
                        transition:.2s ease;
                    }
                        .newdata:hover {
                            background:#fb7171;
                        }

                #style-1::-webkit-scrollbar-track
                {
                    box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                    border-radius: 10px;
                    background-color: #F5F5F5;
                    width:thin;
                }

                #style-1::-webkit-scrollbar
                {
                    width: 5px;
                    background-color: #F5F5F5;
                }

                #style-1::-webkit-scrollbar-thumb
                {
                    border-radius: 10px;
                    box-shadow: inset 0 0 6px rgba(129, 129, 129, 0.3);
                    background-color: #555;
                }
                    .label, .noteslabel {
                        position:absolute;
                        margin-top:-35px;
                        display:inline-block;
                        background:#fb7171;
                        padding:8px 50px 8px 50px;
                        font-family: bahnschrift;
                        font-size:15px;
                        letter-spacing:2px;
                        color:white;
                        border-radius:2px;
                    }
                    .noteslabel {
                        margin-top:-10px;
                        margin-left:25px;
                    }
                    
                    .scheduledata {
                        display:block;
                        background:rgb(255, 255, 255);
                        border-radius:5px;
                        box-shadow:2px 2px 10px rgba(46, 46, 46, 0.151);
                        border:1px solid rgba(119, 119, 119, 0.342);
                        margin-top:20px;
                        padding-left:20px;
                        padding-right:20px;
                        padding-bottom:5px;
                        font-family:bahnschrift;
                        animation: to-top .5s ease;
                    }

                    .assessmentdata {
                        display:block;
                        background:rgb(255, 255, 255);
                        border-radius:5px;
                        box-shadow:2px 2px 10px rgba(46, 46, 46, 0.151);
                        border:1px solid rgba(119, 119, 119, 0.342);
                        margin-top:20px;
                        padding-left:20px;
                        padding-right:20px;
                        padding-bottom:5px;
                        font-family:bahnschrift;
                        overflow:hidden;
                        animation: to-top .5s ease;
                    }
                        .assessmentdata #deadline {
                            color:#2387f7;
                            letter-spacing:2px;
                            font-stretch:extra-expanded;
                            font-size:18px;
                            margin-bottom:-12px;
                        }
                        .assessmentdata #asssubject {
                            color: #2d2d2d;
                            opacity:.7;
                            margin-bottom:2px;
                            font-size:15px;
                            letter-spacing:1px;
                        }
                        .assessmentdata #description {
                            text-align: justify;
                        }

                        .subject {
                            color:#2387f7;
                            letter-spacing: 1px;
                            font-stretch:extra-expanded;
                            font-size:18px;
                            margin-bottom:-12px;
                        }

                        #subjecttitle {
                            color: #2d2d2d;
                            opacity:.7;
                            margin-bottom:2px;
                            font-size:15px;
                        }
                        #lecturername {
                            display:inline-block;
                            background:#ffad4d;
                            color:white;
                            padding:5px 30px 5px 30px;
                            border-radius:5px;
                            font-size:15px;
                            letter-spacing:1px;
                            margin-right:10px;
                        }
                        #platform {
                            display:inline-block;
                            color:black;
                            border:1px solid black;
                            padding:4px 8px 4px 8px;
                            border-radius:5px;
                            font-size:15px;
                            letter-spacing:1px;
                            margin-top:0;
                            text-align:center;
                            opacity:.8;
                        }

                        #savenotes { position:relative;}
                        .tarea {
                            box-shadow:inset 1px 2px 5px #072b4d1c;
                            background:#f6fafc;

                            padding-left:15px;
                            padding-right:15px;
                            width:95%;
                            height:30vh;
                            resize:none;
                            border:0px;
                            padding-top:30px;
                            font-size:15px;
                        }

                        #savenotesbutton {
                            color:white;
                            font-weight:bold;
                            font-size:12px;
                            font-family:Arial, Helvetica, sans-serif;
                            background:#68ddd5;
                            border-radius:15px;
                            padding:8px 15px;
                            box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.15);
                            cursor:pointer;
                            position:absolute;
                            bottom:0;
                            right:0; 
                            margin-bottom:20px;
                            margin-right:20px;
                            opacity:.4;
                            transition:opacity .2s;
                        }
                            #savenotesbutton:hover{
                                opacity:1;
                                background:#fb7171;
                            }

                            .savetooltip {
                                display:none;
                                background-color: rgb(61,61,61);
                                color: #fff;
                                text-align: center;
                                border-radius: 6px;
                                padding-top:5px;
                                padding-bottom:5px;
                                padding-left:10px;
                                padding-right:10px;
                                opacity:.9;
                                font-family:arial;
                                font-size:12px;
                                right:40px;
                                bottom:60px;
                                opacity:.7;

                                /* Position the tooltip */
                                position: absolute;
                                z-index: 1;
                            }

                .right-content {
                    display:grid;
                    grid-template-rows:1fr 1fr;
                    grid-gap:1vw;
                    margin-right:2vw;
                }
                @media screen and (min-width:711px) and ( max-width: 1140px) {
                    body {
                        padding-bottom:20px;
                    }
                    .right-content {
                        grid-column-start:1;
                        grid-column-end:span 2;
                        grid-template-columns:repeat(2,1fr);
                        grid-template-rows:1fr;
                        grid-gap:40px;
                    }
                    .tarea {
                        height:45vh;
                    }
                }

                @keyframes to-top {
                    0% {
                        transform: translateY(100%);
                        opacity: 0;
                    }
                    100% {
                        transform: translateY(0);
                        opacity: 1;
                    }
                }

                @keyframes content-trans {
                    0% { opacity: 0;}
                }
                
                #calendarsection {
                    position:relative;
                    height:100%;
                    text-align:center;
                    overflow:hidden;
                    /* background:pink; */
                }

        </style>
        <div class = "main">
            <div class = "header">
                <div class = "left">
                    <div id = "title">
                        <h2>Timetable Dashboard</h2>
                    </div>
                    <button class = "sel" id = "selbutton">Click to choose class</button>
                    <div id = "dateday">
                        <button class = "arrowday" arrow-id = "left" >&lt;</button>
                        <button class = "arrowday" arrow-id = "right">&gt;</button>
                        <p id = "daytext">Day</p>
                    </div>
                </div>
                <div class = "right">
                    <div id = "currentday" >
                        <h2 id = "today">10:27 PM <p2 style = "color: #fb7171">3 MAY</p2></h2>
                        <p id = "datetoday">27 OCTOBER</p>
                    </div>
                </div>
            </div>
            <div class = "content">
                <div class = "schedule" id = "style-1">
                    <label class = "label">SCHEDULE</label>
                    <div id = "schedule-container">

                        <!-- <div class = "scheduledata">
                            <p id = "subject"><b>ISP250: 10 AM - 12 PM</b></p>
                            <p id = "subjecttitle">System Information</p>
                            <p id = "lecturername">Madam Nurul Husna</p>
                            <p id = "platform">ODL-S</p>
                        </div> -->
                    </div>
                    <button class = "newdata" content-id = "schedulecontent">+ Add new data</button>
                </div>
                <div class = "assessment" id = "style-1">
                    <label class = "label">ASSESSMENT</label>
                    <div id = "assessment-container">

                        <!-- <div class = "assessmentdata">
                            <p id = "deadline"><b>10 MAY 2020</b></p>
                            <p id = "asssubject">System Information</p>
                            <p id = "description">
                                Lorem ipsum is jus a bunch of words combining togeether making a better
                                poem and better paragraphs which helpsp the devloper to grasp a better 
                                details
                            </p>
                        </div> -->
                    </div>
                    <button class = "newdata" content-id = "assessmentcontent">+ Add new data</button>
                </div>
                <div class = "right-content">
                    <div class = "notes">
                        <div id = "savenotes" id = "style-1">
                            <label class = "noteslabel">NOTES</label>
                            <textarea class = "tarea" name="text1" maxlength="500" id = "notes-container">this notes area can only have 500 characters</textarea>
                            <div id = "savenotesbutton">Save notes</div><span class="savetooltip">Saved!</span>
                        </div>
                    </div>
                    <div id = "calendarsection">
                        <script>
                            $(document).ready(function(){ 
                                $.get("calendar.html", function(data) {
                                    $("#calendarsection").html(data);
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
