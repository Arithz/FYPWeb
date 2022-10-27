<!DOCTYPE html>
    <?php
        include ('dbcon.php');
        session_start();
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <title>Request Status | Timetable Generator</title>
    </head>

    <body>
        <div id = "menu"></div>
        <div id = "form"></div>
        <script>
            $(document).ready(function(){ 
                $.get("nav.html", function(data) {
                    $("#menu").html(data);
                });

                //get form page
                $.get("form.php", function(data) {
                    $("#form").html(data);
                });

                $("html").on("click", function(event){ 
                    if($("#input-search").val() != "") {
                        $(".la").addClass("labelsearch");
                        $(".la").removeClass("la"); 
                    }else {
                        $(".labelsearch").addClass("la"); 
                        $(".labelsearch").removeClass("labelsearch"); 
                    }
                });

                $("#filterupper").click(function(){
                        $(".filterform").slideToggle();
                });
            });
        </script>

        <style>
            @font-face{
                font-family: bahnschrift;
                src: url(Fonts/Bahnschrift/BAHNSCHRIFT.TTF);
            }

            @media screen and (max-width: 900px) {
                .main { margin-left:4vw !important; margin-top: 60px; padding-right:20px;}
                #desc { width:60ch; font-size:15px;}
                #content {
                    grid-auto-flow:row;
                    grid-template-columns:repeat(1,1fr) !important;
                    grid-template-rows:repeat(auto-fit, minmax(100px,1fr)) !important;
                }
                #filter {
                    grid-row-start:2 !important;
                    grid-row-end:2;
                }
            }

            @media screen and (max-width: 700px) {
                #desc {
                    width:80vw !important;}
                #content {
                    grid-template-columns:repeat(1,1fr);
                    grid-template-rows:repeat(4,1fr);
                }

                table {
                    border: 0;
                }

                table caption {
                    font-size: 1.3em;
                }
                
                table thead {
                    border: none;
                    clip: rect(0 0 0 0);
                    height: 1px;
                    margin: -1px;
                    overflow: hidden;
                    padding: 0;
                    position: absolute;
                    width: 1px;
                }
                
                table tr {
                    border-bottom: 3px solid #ddd;
                    display: block;
                    margin-bottom: .625em;
                }
                
                table td {
                    border-bottom: 1px solid #ddd;
                    display: block;
                    font-size: .8em;
                    text-align: right !important;
                    font-family:bahnschrift;
                }
                
                table td::before {
                    /*
                    * aria-label has no advantage, it won't be read inside a table
                    content: attr(aria-label);
                    */
                    content: attr(data-label);
                    float: left;
                    font-weight: bold;
                    text-transform: uppercase;
                }
                
                table td:last-child {
                    border-bottom: 0;
                }
            }

            body { margin:0;}
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

            /* .header { background-color:pink;}
            .content { background-color:cyan;}  */

            .header {
                margin-top:10px;
            }
                #desc {
                    width:60ch;
                    margin-top:-10px;
                    line-height: 1.6;
                    font-family:bahnschrift;
                    font-size:17px;
                    opacity:.8;
                    font-kerning:none;
                }
                    #desc p {
                        text-align: justify;
                    }

                #title h2 {
                    font-family: bahnschrift;
                    font-size:30px;
                    color:hsl(0, 0%, 17%);

                    letter-spacing:1px;
                    margin-bottom:8px;
                }

            #content {
                margin-top:20px;
                margin-right:30px;
                display:grid;
                grid-auto-flow:row;
                grid-template-rows:auto 1fr;
                grid-gap:20px;
            }  
                .list {
                    position:relative;
                    grid-column-start:1;
                    grid-column-end:1;
                    grid-row-end:span 2;
                    margin-bottom:30px;
                }

                table {
                    border: 1px solid #ccc;
                    border-collapse: collapse;
                    margin: 0;
                    padding: 0;
                    width:100%;
                    table-layout:auto;
                }

                table caption {
                    font-size: 1.5em;
                    margin: .5em 0 .75em;
                }

                table tr {
                    background-color: #f8f8f8;
                    border: 1px solid #ddd;
                    padding: .35em;
                }

                table th,
                table td {
                    padding: .625em;
                    padding-left:20px;
                    text-align: left;
                    font-family:bahnschrift;
                    font-size:16px;
                    line-height: 25px;
                }
                table th {
                    padding-top:12px;
                    padding-bottom:12px;
                    font-size: .85em;
                    letter-spacing: .1em;
                    text-transform: uppercase;
                    background:#3b3b3b;
                    color:white;
                    font-family:bahnschrift !important;
                } 

                #extra {
                    display:flex;
                    grid-auto-flow: column;
                    margin:0;
                }

                #notice {
                    margin-left:20px;
                    background:#e4f0ff;
                    width:auto;
                    height:fit-content;
                    padding-top:15px;
                    padding-bottom:13px;
                    padding-left:8px;
                    padding-right:15px;
                    transition:0.2s ease;
                    font-family:18px;
                }
                #notice:hover {
                    transform:translateY(-10%);
                    box-shadow: 1px 2px 5px #072b4d94;
                }
                    #notice p{
                        color:black;
                        font-family:bahnschrift;
                        margin:0;
                        margin-left:10px;
                        opacity:.8;
                        font-size:18px;
                        font-kerning: none;
                    }

                    #filterupper {
                        cursor:pointer;
                        background:#3b3b3b;
                        padding-top:15px;
                        padding-bottom:1px;
                        padding-left:102px;
                        padding-right:103px;
                        width:max-content !important;
                        height:max-content !important;
                        height:15px;
                        transition:0.2s ease;
                        font-family:18px;
                    }
                    #filterupper:hover {
                        box-shadow: 1px 2px 5px #072b4d94;
                    }

                    #filter p {
                        color:white;
                        text-align:center;
                        font-family:bahnschrift;
                        margin-top:0;
                    }

                    #filter {
                        margin:0;
                        height:min-content;
                    }

                    .filterform {
                        display:none;
                        z-index:1;
                        position:fixed;
                        background:#f9f9f9;
                        padding-top:30px;
                        padding-bottom:20px;
                        padding-left:50px;
                        padding-right:50px;
                        box-shadow: 1px 2px 5px #072b4d94;
                    }

                    .wrapper input {
                            border:none;
                            transition: 0.6s;
                            border-bottom: 2px solid #a7a7a7;
                            background-color: transparent;
                            width:98%;
                            font-size:16px;
                        }
                        .wrapper input:focus {
                            outline:none;
                            border-bottom:2px solid #fb7171;
                        }
                        .wrapper .la {
                            position:absolute;
                            display:block;
                            margin-top:-25px;
                            transition: 0.3s ease;
                            font-size:14px;
                            font-family:arial;
                            color:#a7a7a7;
                        }
                        .wrapper input:focus + .la {
                            transition:0.3 ease;
                            transform:translate(2px,-8px);
                            font-size:10px;
                            color:#3b3b3b;
                            opacity:.9;
                        }

                        .labelsearch {
                            position:absolute;
                            display:block;
                            margin-top:-32px;
                            margin-left:2px;
                            transition:0.3 ease;
                            font-size:10px;
                            color:#3b3b3b;
                            font-family:arial;
                            opacity:.9;
                        }

                        .sel {
                            background: #616161;
                            border-radius:5px;
                            color:white;
                            text-align:left;
                            margin-bottom:20px;
                            font-size:15px;
                            width:100%;
                            font-family:arial; 
                        }
                            .date, .category, .status { padding:3px 10px 3px 10px;}
                            
                        #filtersubmit {
                            border:none;
                            background:#fb7171;
                            color:white;
                            border-radius:5px;
                            padding:4px 18px 4px 18px;
                            font-size:16px;
                            margin-top:0.8vh;
                            transition:.1s ease-in-out;
                        }
                        #filtersubmit:hover { background:#68ddd3}
        </style>

        <div class = "main">
            <div class = "header">
                <div class = "left">
                    <div id = "title">
                        <h2>Request Status</h2>
                    </div>
                    <div id = "desc">
                        <p> 
                            The following requests will be seen by the administrator in order to be approve/decline.
                            Please be patience for the action taken by the administrator.
                        </p>
                    </div>
                </div>
            </div>

            <div id = "content">
                <div id = "extra">
                    <div id = "filter">
                        <div id = "filterupper">
                            <p>Filter Options</p>
                        </div>
                        <form method = "POST" action = "">
                            <div class = "filterform">
                                <div class = "wrapper">
                                    <input type = "text" id = "input-search" name = "search">
                                    <label class = "la" for = "input-search" unselectable="on">Search request name</label>
                                </div>
            
                                <br>
                                <select class = "sel date" name = "filterdate">
                                    <option value = "1">Date ascendingly</option>
                                    <option value = "2">Date descendingly</option>
                                </select>
                                <br>
                                <select class = "sel category" name = "filtercategory">
                                    <option selected value = "">Category</option>
                                    <option value = "Lecturer">Lecturer</option>
                                    <option value = "Subject">Subject</option>
                                    <option value = "Class">Class</option>
                                    <option value = "Schedule">Schedule</option>
                                </select>
                                <br>
                                <select class = "sel status" name = "filterstatus">
                                    <option selected value = "">Request Status</option>
                                    <option value = "1">Waiting for approval</option>
                                    <option value = "2">Accepted</option>
                                    <option value = "3">Rejected</option>
                                </select>
                                <br>
                                <input type = "submit" id = "filtersubmit" value = "Go" name = "btn_filterrequest">
                            </div>
                        </form>
                    </div>
                    <div id = "notice">
                        <p>Request will be deleted after 2 days getting accepted/declined.</p>
                    </div>
                </div>
                <div class = "list">
                    <?php
                        if (isset($_POST['btn_filterrequest'])) {
                            $search = mysqli_real_escape_string($db, $_POST['search']);
                            $seldate = mysqli_real_escape_string($db, $_POST['filterdate']);
                            $category = mysqli_real_escape_string($db, $_POST['filtercategory']);
                            $status = mysqli_real_escape_string($db, $_POST['filterstatus']);

                            if($seldate === "1") { 
                                $query = 
                                "SELECT request.Request_Description, request.Request_Category, DATE_FORMAT(request.Request_Date, '%d/%m/%Y %H:%i') as Request_Date, 
                                status.Status_Description from request 
                                inner join status ON request.Status_ID = status.Status_ID 
                                where request.Request_Description like '%$search%' AND request.Request_Category like '$category%' AND request.Status_ID like '%$status%'
                                order by request.Request_Date asc";
                            }
                            else if ($seldate === "2") { 
                                $query = 
                                "SELECT request.Request_Description, request.Request_Category, DATE_FORMAT(request.Request_Date, '%d/%m/%Y %H:%i') as Request_Date, 
                                status.Status_Description from request 
                                inner join status ON request.Status_ID = status.Status_ID 
                                where request.Request_Description like '%$search%' AND request.Request_Category like '$category%' AND request.Status_ID like '%$status%'
                                order by request.Request_Date desc";
                            }

                            $data = mysqli_query($db, $query);
                            $row = mysqli_num_rows($data);
                            $search_result = filterTable($query);

                        }else {
                            $query = "DELETE FROM request WHERE Request_Date < NOW() - INTERVAL 2 DAY AND Status_ID != '1'";
                            $db->query($query);
                            $query = "SELECT request.Request_Description, request.Request_Category, DATE_FORMAT(request.Request_Date, '%d/%m/%Y %H:%i') as Request_Date, status.Status_Description 
                                    from request inner join status 
                                    ON request.Status_ID = status.Status_ID ORDER BY Request_Date asc";
                            $data = mysqli_query($db, $query);
                            $row = mysqli_num_rows($data);
                            $search_result = filterTable($query);
                        }

                        function filterTable($query) {
                            include ('dbcon.php');
                            $filter_result = mysqli_query($db,$query);
                            return $filter_result;
                        }
                    ?>
                    <table>
                        <thead>
                          <tr>
                            <th scope="col">Date created</th>
                            <th scope="col">Category</th>
                            <th scope="col">Request Description</th>
                            <th scope="col">Status Approval</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php while($result = mysqli_fetch_assoc($search_result)) :?>
                            <tr>
                                <td data-label="Date created"><?php echo $result['Request_Date'];?></td>
                                <td data-label="Category"><?php echo $result['Request_Category'];?></td>
                                <td data-label="Description"><?php echo nl2br($result['Request_Description']);?></td>
                                <td data-label="Status"><?php echo $result['Status_Description'];?></td>
                            </tr>
                            <?php endwhile; ?>
                            <td colspan = "4" ><?php echo "Total request number : " . $row;?></td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>