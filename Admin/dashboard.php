<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <title>Admin Dashboard | Timetable Generator</title>
    </head>
    
    <?php 
        session_start();
        include ('../dbcon.php');

        if(!isset($_SESSION['username'])) {
            print "<script>window.location.assign('../index.php');</script>";
        }else {
            $countquery = "SELECT * FROM request where Status_ID = '1'"; 
            $data = mysqli_query($db, $countquery);
            $row = mysqli_num_rows($data);

            $_SESSION['username'] = $username;
        }
    ?>

    <body>
        <div id = "menu"></div>
        <script>
            $(document).ready(function(){ 
                var username = '<?php echo $username; ?>';
                $.get("../Admin/adminnav.html", function(data) {
                    $("#menu").html(data);
                });

                $('#history').on('click',function () {
                    $('.form-container').fadeToggle();
                    $('#seshistory').fadeToggle();
                });

                $('.close').on('click',function(){
                    $('.form-container').fadeToggle();
                    $('#seshistory').fadeToggle();
                });

                //fetch lecturer 
                if(username) {
                    load_lecturer("lecturer");
                    load_class("class");
                    load_subject("subject");
                    load_schedule("schedule");
                    load_history();
                };

                function load_lecturer(query) {
                    $.ajax ({
                        url:"../AdminProcess/fetchrequest.php",
                        method:"POST",
                        data: { query : query },
                        success: function(data) {
                            $('#lecturer-container').html(data);
                        }
                    });
                }

                function load_class(query) {
                    $.ajax ({
                        url:"../AdminProcess/fetchrequest.php",
                        method:"POST",
                        data: { query : query },
                        success: function(data) {
                            $('#class-container').html(data);
                        }
                    });
                }

                function load_subject(query) {
                    $.ajax ({
                        url:"../AdminProcess/fetchrequest.php",
                        method:"POST",
                        data: { query : query },
                        success: function(data) {
                            $('#subject-container').html(data);
                        }
                    });
                }

                function load_schedule(query) {
                    $.ajax ({
                        url:"../AdminProcess/fetchrequest.php",
                        method:"POST",
                        data: { query : query },
                        success: function(data) {
                            $('#schedule-container').html(data);
                        }
                    });
                }

                function load_history() {
                    $.ajax ({
                        url:"../AdminProcess/fetchhistory.php",
                        method:"POST",
                        success: function(data) {
                            $('#history-container').html(data);
                        }
                    });
                }
            });
        </script>
        <style>
            body {
                display:grid;
                background: #f3f8ff;

                padding-left:130px;
                padding-right:20px;
                padding-top:10px;
            }

            @media screen and (max-width: 900px) {
                body { 
                    padding-left:0px; 
                    padding-right:0; 
                    padding-top:0px;

                    overflow:visible;
                }
                .header,.extra, .content {margin-left:20px; margin-right:20px;}
                .header {margin-top:60px;}
                .content { margin-bottom:60px;}

                .extra {
                    display:grid;
                    grid-auto-flow: row;
                    grid-template-rows: repeat(3, 1fr);
                }
            }
                
                #title h2 {
                    font-family: bahnschrift;
                    font-size:30px;
                    color:hsl(0, 0%, 17%);

                    letter-spacing:1px;
                    margin-bottom:8px;
                }


            /* .main { background:purple; }
                .header {background:green;}
                .extra { background:blue;}
                .content { background:pink;}
                
                    #receive {background:rgb(224, 88, 64);}
                    #desc {background:violet;} 
                    #history {background:yellowgreen;} 
                    .request { background: rgb(255, 54, 54);} */


                /* .lecturer{grid-area: r1;}
                .class {grid-area:r2;}
                .subject {grid-area:r3;}
                .schedule {grid-area:r4;} */
                
                .extra {
                    display:grid;
                    grid-auto-flow:column;
                    grid-auto-columns: auto;
                    grid-gap:10px;

                    margin-top:10px;
                }
                    .extra > div {transition:transform 0.2s ease;}
                    .extra > div:hover {
                        transform:translateY(-10%);
                        box-shadow: 1px 2px 5px #072b4d1c;
                    }
                    #receive {
                        border-radius:5px;

                        background: #c6ddff;
                        box-shadow: 0 1px 2.5em rgba(0,0,0,.1);
                        color:#346ec8;

                        height:70px;

                        border-radius:5px;
                        min-width:max-content;

                        font-family:bahnschrift;
                        font-size:16px;
                        text-align: center;
                    } 
                        #reqnumber {
                            font-size:30px;
                            margin-top:10px;
                            min-width:140px;
                        }
                            #reqnumber::after {
                                position:absolute;
                                margin-top:35px;
                                margin-left:-70px;
                                width:16ch;

                                content: 'Request received';
                                font-size:15px;
                            }
                        

                    #desc {
                        background:#fff;
                        box-shadow: 0 1px 2.5em rgba(0,0,0,.1);
                        color:black;

                        height:min-content;
                        min-width:10px;

                        padding-left:25px;
                        padding-right: 25px;
                        border-radius:5px;
                        
                        text-align:center;
                        font-size:16px;
                        font-family:bahnschrift;
                    }

                    #history {
                        text-align: center;
                        align-items: center;

                        background: #6977f9;
                        /* nav background: #040849; */
                        color: white;
                        box-shadow: 0 1px 2.5em rgba(0,0,0,.1);

                        padding-left:25px;
                        padding-right: 25px;
                        border-radius:5px;

                        height:70px;

                        font-size:16px;
                        font-family:bahnschrift;
                        cursor:pointer;
                    }
                    

                .content {
                    display:grid;
                    grid-template-columns:repeat(3,1fr);
                    grid-template-rows:repeat(auto-fit,minmax(100px,1fr));
                    grid-gap:15px;
                    margin-top:30px;
                    margin-bottom:50px;
                }
                    /* .lecturer {background:pink;}
                    .class {background: gray;}
                    .subject {background:blue;}
                    .schedule {background:rgb(104, 110, 108);} */

                    .left {display:flex; flex-direction: column; gap:20px; }
                    /* normal */
                    .lecturer {
                        grid-column-start: 1;
                        grid-column-end:1;
                        grid-row-start:1;
                        grid-row-end:1;
                    }
                    .class {
                        grid-column-start: 1;
                        grid-column-end:1;
                    }
                    .subject {
                        grid-column-start:2;
                        grid-column-end:2;
                        grid-row-start: 1;
                        grid-row-end:span 2;
                    }
                    .schedule {
                        grid-column-start:3;
                        grid-column-end:3;
                        grid-row-start: 1;
                        grid-row-end:span 2;
                    }

                    /*2 by 2 */
                    @media screen and (max-width: 1350px) {
                        .content {
                            grid-template-rows:repeat(auto-fit,minmax(100px,1fr));
                            grid-template-columns:repeat(2,1fr);
                        }
                        .left {display:flex; flex-direction: row; gap:20px; grid-column-start:1; grid-column-end:span 2; height:fit-content; }
                        .lecturer {
                            flex-basis: 50%;
                            grid-column-start: 1;
                            grid-column-end:1;
                        }
                        .class {
                            flex-basis: 50%;
                            grid-column-start: 2;
                            grid-column-end:2;
                            grid-row-start: 1;
                            grid-row-end:1;
                        }
                        .subject {
                            grid-column-start:1;
                            grid-column-end:1;
                            grid-row-start: 2;
                            grid-row-end:2;
                        }
                        .schedule {
                            grid-column-start:2;
                            grid-column-end:2;
                            grid-row-start: 2;
                            grid-row-end:2;
                        }
                    }

                    /*1 by 4 */
                    @media screen and (max-width: 800px) {
                        .content {
                            grid-template-columns:repeat(1,1fr);
                            grid-template-rows:repeat(auto-fit,minmax(100px,1fr));
                            column-gap:0;
                        }
                        .left {display:flex; flex-direction: column; gap:20px; grid-column-start:1; padding-right:0px; }
                        .lecturer {
                            grid-column-start: 1;
                            grid-column-end:1;
                            grid-row-start: 1;
                            grid-row-end:1;
                        }
                        .class {
                            grid-column-start: 1;
                            grid-column-end:1;
                            grid-row-start: 2;
                            grid-row-end:2;
                        }
                        .subject {
                            grid-column-start:1;
                            grid-column-end:1;
                            grid-row-start: 3;
                            grid-row-end:3;
                        }
                        .schedule {
                            grid-column-start:1;
                            grid-column-end:1;
                            grid-row-start: 4;
                            grid-row-end:4;
                        }
                    }

                    .request {
                        background:hsl(0, 0%, 98%);
                        box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.144);

                        padding-left:25px;
                        padding-right:30px;
                        padding-bottom:20px;
                        border-radius:5px;

                        font-family:bahnschrift;
                        font-size:18px;
                    }
                        .request:nth-child(1) { height:min-content; }
                        .request:nth-child(2) { height:min-content; }
                        .request:nth-child(3) { height:min-content; }
                        .request:nth-child(4) { height:min-content; }

                        #item {
                            display:block;
                            overflow:visible;

                            background:#f5f5f5;
                            border:1px solid gray,;

                            padding:5px 20px 10px 20px;
                            margin-bottom:25px;

                            border-radius:5px;
                            font-size:15px;
                            font-family:bahnschrift;
                            min-width:320px;
                            height:auto;
                            box-shadow: 6px 6px 8px #e6e6e6,
                                        -6px -6px 8px #ffffff;
                            
                            animation:to-top .5s ease;
                        }
                        #item::before {
                            position:relative;
                            display:block;
                            content: '';
                            background:#50a2c8;

                            margin-top:-5px;
                            height: 3px;
                            border-radius:10px;
                        }
                            .sch p3 {
                                border-bottom:1px solid rgba(48, 48, 48, 0.397);
                            }
                            #item p {
                                display:inline-block;
                                margin-top:1.5vh;
                                margin-bottom:5px;
                                height:auto;
                            }
                            #item #decline {
                                    float:right;
                                    position:inherit;
                                    margin-top:1.25vh;
                                    margin-left:5px;
                                    cursor:pointer;
                                    font-size:13px;

                                    background:#d16666;
                                    color:white;
                                    border-radius:3px;
                                    padding-left:12px;
                                    padding-right:12px;
                                    padding-top:3px;
                                    padding-bottom:3px;
                                    text-decoration:none;
                                    transition:.2s;
                            }
                            #item #approve {
                                    float:right;
                                    position:inherit;
                                    margin-top:1.25vh;
                                    font-size:13px;

                                    cursor:pointer;
                                    background:#21b573;
                                    color:white;
                                    border-radius:3px;
                                    padding-left:12px;
                                    padding-right:12px;
                                    padding-top:3px;
                                    padding-bottom:3px;
                                    text-decoration:none;
                                    transition:.2s;
                            }

                            #item #approve:hover , #item #decline:hover {
                                background:#6977f9;
                                color:white;
                            }

                            #item p4 {
                                    margin-top:0;
                                    width:35ch;
                                    display:block;
                                    line-height:35px;
                            }

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

                        .close{
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

                        .close:hover{
                            color:#505050;
                            transform: rotate(180deg);
                        }

                        #seshistory {
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
                            animation:to-top 0.5s ease;

                            display:none;

                            height: 300px;
                            width: clamp(300px, 60vw, 480px);
                            padding-bottom:20px;
                            padding-top:20px;
                            padding-left:20px;
                            padding-right:30px;
                            overflow-y:scroll;
                        }

                        #history-container p {
                            border-radius:5px;

                            margin-top:10px;
                            margin-bottom:10px;
                            margin-left:20px;
                            margin-right:20px;
                            

                            padding-top:10px;
                            padding-bottom:10px;
                            padding-left:20px;
                            padding-right:20px;
                            height:fit-content;

                            position: relative;
                            background: white;
                            overflow: hidden;
                            box-shadow: 0 8px 20px rgba(110, 110, 110, 0.15);
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
        </style>
        <div class = "form-container">
            <div id = "seshistory">
                <span class="close">&times;</span>
                <div id = "history-container">
                </div>
            </div>
        </div>

        <div class = "header">
            <div id = "title">
                <h2>Admin Dashboard</h2>
            </div>
        </div>
        <div class = "extra">
            <div id = "desc">
                <p> Welcome to the administrator dashboard. <br>
                    Please make an approval to each of the request.
                </p>
            </div>
            <div id = "receive">
                <p id = "reqnumber"><b><?php echo  $row;?></b></p>
            </div>
            <div id = "history">
                <p>Login History</p>
            </div>
        </div>
        <div class = "content">
            <div class = "left">
                <div class = "lecturer request">
                    <p id = "reqtitle">Lecturer Request</p>
                    <div id = "lecturer-container">
                    </div>
                </div>
                <div class = "class request">
                    <p id = "reqtitle">Class Request</p>
                    <div id = "class-container">
                    </div>
                </div>
            </div>
            <div class = "subject request">
                <p id = "reqtitle">Subject Request</p>
                <div id = "subject-container">
                </div>

            </div>
            <div class = "schedule request">
                <p id = "reqtitle">Schedule Request</p>
                <div id = "schedule-container">
                </div>
            </div>
        </div>
    </body>
</html>