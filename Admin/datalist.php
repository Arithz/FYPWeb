<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

        <title>Admin Dashboard | Timetable Generator</title>
    </head>

    <body>
        <div id = "menu"></div>
        <script>
            $(document).ready(function(){ 
                $.get("../Admin/adminnav.html", function(data) {
                    $("#menu").html(data);
                });

                load_category('class');
                $('#list-cat').on('change', function() {
                    if(this.value == 'class') {
                        $('#datatitle').text('Class Data');
                        load_category('class','');
                    }
                    if(this.value == 'lecturer') {
                        $('#datatitle').text('Lecturer Data');
                        load_category('lecturer','');
                    }
                    if(this.value == 'subject') {
                        $('#datatitle').text('Subject Data');
                        load_category('subject','');
                    }
                    if(this.value == 'schedule') {
                        $('#datatitle').text('Schedule Data');
                        load_category('schedule','');
                    }
                });

                //search function
                $('#gosearch').on('click',function() {
                    if($('#search_txt').val() != "") {
                        var search = $('#search_txt').val();
                        var query = $('#search_sel').val();
                        $('#list-cat').val($('#search_sel').val());
                        load_category(query, search);
                    }
                })
            });

            //start li on transition animation start
            $(document).on('click', '.bi', function() {
                if(confirm("Deleting this data will delete other data related to it. Proceed?")) {
                    var data = $(this).attr('data');
                    var type = $(this).attr('type');
                    delete_data(data,type);
                    $(this).closest('.table-row').addClass('removed');
                }
            });

            // remove li on transition animation end
            $(document).on('transitionend', '.removed', function() {
                $(this).remove();
            });

            //ajax load category
            function load_category(query, search) {
                $.ajax ({
                    url: '../AdminProcess/fetchdata.php',
                    method:"POST",
                    data: { query : query, search : search },
                    success: function(data) {
                        $('#category-container').html(data);
                    }
                });
            }

            //ajax delete data
            function delete_data(data,type) {
                $.ajax ({
                    url: '../AdminProcess/fetchdata.php',
                    method:"POST",
                    data: { data : data , type : type}
                });
            }

        </script>

        <style>
            body {
                display:grid;
                background: #f3f8ff;

                padding-left:130px;
                padding-right:30px;
                padding-top:15px;
            }

            @media screen and (max-width: 900px) {
                body { 
                    padding-left:0px; 
                    padding-right:0; 
                    padding-top:0px;

                    overflow:visible;
                }
                .header {margin-top:60px;}
            }

            .header #title h2 {
                font-family: bahnschrift;
                font-size:25px;
                color:hsl(0, 0%, 17%);

                letter-spacing:1px;
                margin-bottom:8px;
            }

            .extra {
                border-radius:10px;

                margin-top:20px;
                margin-bottom:10px;

                padding-top:10px;
                padding-bottom:10px;
                padding-left:25px;
                padding-right:25px;

                position: relative;
                background: white;
                overflow: hidden;
                box-shadow: 0 8px 20px rgba(110, 110, 110, 0.15);
            }

                .extra::before {
                    content: '';
                    position: absolute;
                    background: inherit;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    margin: -20px;
                    box-shadow: inset 0 0 20px rgba(255, 255, 255, .4); 
                    filter: blur(10px);
                    z-index: -1;
                }

            .search table {
                border:0;
                width:100%;
                font-family:bahnschrift;
                border-spacing: 5px;

            }
                .search table tr, td {
                    /* border:1px solid black; */
                    padding-left:5px;
                    padding-right:5px;
                    text-align: center;
                }

                .search table tr {
                    margin-top:5px;
                    margin-bottom:5px;
                    text-align: center;
                }

                .search input[type=text] {
                    background:#f9faff;
                    border:0;
                    outline:none;
                    width:90%;
                    border-radius:5px;
                    padding-top:6px;
                    padding-bottom:6px;
                    padding-left:10px;
                    padding-right:10px;
                    box-shadow:inset 1px 2px 5px #072b4d1c;
                    font-size:15px;
                }

                .search select {
                    width:100%;
                    border-radius:5px;
                    cursor:pointer;
                    background:white;
                    padding-top:6px;
                    padding-bottom:6px;
                    padding-left:10px;
                    padding-right:10px;
                    outline:none;
                    border:1px solid rgb(185, 185, 185, 0.6);
                    box-shadow:inset 1px 2px 5px #072b4d1c;
                }

                .search input[type=submit] {
                    background:#6977f9;
                    color:white;
                    font-family:bahnschrift;
                    font-size:15px;
                    outline:none;
                    border:0;
                    border-radius:5px;
                    cursor:pointer;
                    width:fit-content;
                    padding-top:6px;
                    padding-bottom:6px;
                    padding-left:25px;
                    padding-right:25px;
                    text-align: center;
                    transition: 0.15s ease-in;
                }
                
                .search input[type=submit]:hover {
                    background:#fb7171;
                }

            .list {
                border-radius:10px;

                margin-top:20px;
                margin-bottom:30px;

                padding-top:20px;
                padding-bottom:20px;
                padding-left:20px;
                padding-right:20px;
                height:fit-content;

                position: relative;
                background: white;
                overflow: hidden;
                box-shadow: 0 8px 20px rgba(110, 110, 110, 0.15);
            }

            .showcat {
                display:flex;
                flex-direction: row;
            }
            .showcat #title {
                height:fit-content;
                padding:0;
                font-family:arial;
                font-size:12px;
                position:relative;
                flex-basis: 90%;
            }
            .showcat #title h2{ margin:0; }
            .showcat p {
                margin:0;
                margin-top:5px;
                margin-right:10px;
                font-family:arial;
                font-size:15px;
            }
            .showcat select {
                height:30px;
                padding-top:0;
                border-radius:5px;
                cursor:pointer;
                background:white;
                padding-top:6px;
                padding-bottom:6px;
                padding-left:15px;
                padding-right:15px;
                outline:none;
                border:1px solid rgb(185, 185, 185, 0.6);
                box-shadow:inset 1px 2px 5px #072b4d1c;
            }
            .cactive {
                display:block !important;
                animation:to-top .7s;
            }

            .bi-trash {
                display:block;
                width:fit-content;
                margin-top:-4px;
                background:#fb7171;
                color:white;
                font-size:15px;
                font-style: normal;
                padding:5px 10px;
                border-radius:4px;
                cursor:pointer;
                transition:.2s ease;
            }
            .bi-trash:hover{
                background:#e22e2e;
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

            #classtable {display:none;}
            #subjecttable {display:none;}
            #lecturertable {display:none;}
            #scheduletable {display:none;}

            .responsive-table {
                list-style-type:none;
                padding-left:0;
            }
            .responsive-table li {
                padding: 15px 20px;
                border:1px solid rgba(90, 90, 90, 0.192);
                display: flex;
                justify-content: space-between;
                transition: all 0.3s ease-out;
                font-family:arial;
            }
                .removed {
                    transition: all 0.5s ease-out;
                    opacity: 0;
                }

            .table-header {
                border-radius: 5px 5px 0px 0;
                background-color: #6977f9;
                font-family:bahnschrift;
                color:white;
                font-size: 14px;
                text-transform: uppercase;
                letter-spacing: 0.03em;
            }
            .table-row {
                background-color: #fff;
                box-shadow: 0px 0px 9px 0px rgba(0,0,0,1%);
                transition:0.2s ease;
            }
                .table-row:hover {
                    box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.1);
                }
            .col-1 {
                flex-basis: 15%;
            }
            .col-2 {
                flex-basis: 40%;
            }
            .col-3 {
                flex-basis: 10%;
            }
            .col-4 {
                flex-basis: 10%;
            }
            
            .sc-1 { flex-basis: 2%;}
            .sc-2 { flex-basis: 20%;}
            .sc-3 { flex-basis: 12%;}
            .sc-4 { flex-basis: 12%;}
            .sc-5 { flex-basis: 8%;}
            .sc-6 { flex-basis: 8%;}
            .sc-7 { flex-basis: 12%;}
            .sc-8 { flex-basis: 10%;}

            @media screen and (max-width: 900px) {
                body {
                    padding-left:20px; 
                    padding-right:20px; 
                    padding-top:0px;

                    overflow:visible;
                }
                .table-header {
                    display: none !important;
                }
                .table-row {
                    display: block !important;
                    margin-bottom:10px !important;
                }
                .col {
                    flex-basis: 100% !important;
                }
                .col {
                    display: flex !important;
                    padding: 5px 0 !important;
                }
                    .col:before {
                        color: #6C7A89 !important;
                        padding-right: 10px !important;
                        content: attr(data-label) !important;
                        flex-basis: 50% !important;
                        text-align: right !important;
                    }
            }

        </style>
        <div class = "header">
            <div id = "title">
                <h2>Data List</h2>
            </div>
        </div>
        <div class = "extra">
            <div class = "search">
                <table>
                    <tr>
                        <td>What are you looking for?</td>
                        <td>Category</td>
                        <td>Go</td>
                    </tr>
                    <tr>
                        <td><input type = "text" id = "search_txt" placeholder="Search for name of the data"></td>
                        <td width = "20%">
                            <select name = "select-cat" id = "search_sel">
                                <option value = "class">Class category</option>
                                <option value = "lecturer">Lecturer category</option>
                                <option value = "subject">Subject category</option>
                                <option value = "schedule">Schedule category</option>
                            </select>
                        </td>
                        <td width = "12%">
                            <input type = "submit" name = "gosearch" id = "gosearch">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class = "list">
            <div class = "showcat">
                <div id = "title">
                    <h2 id = "datatitle">Class Data</h2>
                </div>
                <p>Show: </p>
                <select id = "list-cat" name = "list-cat">
                    <option value = "class">Class category</option>
                    <option value = "lecturer">Lecturer category</option>
                    <option value = "subject">Subject category</option>
                    <option value = "schedule">Schedule category</option>
                </select>
            </div>
            <div id = "category-container">
            </div>
            
            <!--
            //class table
            <div id = "classtable" class = "cactive">
                <ul class="responsive-table">
                    <li class="table-header">
                      <div class="col col-1">Class ID</div>
                      <div class="col col-2">Class Name</div>
                      <div class="col col-3">Category</div>
                      <div class="col col-4">Action</div>
                    </li>
                    <li class="table-row">
                      <div class="col col-1" data-label="Class ID">42235</div>
                      <div class="col col-2" data-label="Class Name">John Doe</div>
                      <div class="col col-3" data-label="Category">$350</div>
                      <div class="col col-4" data-label="Action"><i class="bi bi-trash">&nbsp;Delete</i></div>
                    </li>
                </ul>
            </div>

            //subject table 
            <div id = "subjecttable">
                <ul class="responsive-table">
                    <li class="table-header">
                        <div class="col col-1">Subject Code</div>
                        <div class="col col-2">Subject Name</div>
                        <div class="col col-3">Category</div>
                        <div class="col col-4">Action</div>
                    </li>
                    <li class="table-row">
                        <div class="col col-1" data-label="Subject Code">42235</div>
                        <div class="col col-2" data-label="Subject Name">John Doe</div>
                        <div class="col col-3" data-label="Category">$350</div>
                        <div class="col col-4" data-label="Action">Pending</div>
                    </li>
                </ul>
            </div>

            //lecturer table
            <div id = "lecturertable">
                <ul class="responsive-table">
                    <li class="table-header">
                        <div class="col col-1">Lecturer ID</div>
                        <div class="col col-2">Lecturer Name</div>
                        <div class="col col-3">Category</div>
                        <div class="col col-4">Action</div>
                    </li>
                    <li class="table-row">
                        <div class="col col-1" data-label="Lecturer ID">42235</div>
                        <div class="col col-2" data-label="Lecturer Name">John Doe</div>
                        <div class="col col-3" data-label="Category">$350</div>
                        <div class="col col-4" data-label="Action"><i class="bi bi-trash">&nbsp;Delete</i></div>
                    </li>
                </ul>
            </div>

            // schedule table
            <div id = "scheduletable">
                <ul class="responsive-table">
                    <li class="table-header">
                        <div class="col sc-1">Schedule ID</div>
                        <div class="col sc-2">Lecturer Name</div>
                        <div class="col sc-3">Class Name</div>
                        <div class="col sc-4">Subject Code</div>
                        <div class="col sc-5">Location</div>
                        <div class="col sc-6">Day</div>
                        <div class="col sc-7">Time</div>
                        <div class="col sc-8">Action</div>
                    </li>
                    <li class="table-row">
                        <div class="col sc-1" data-label="Schedule ID">42235</div>
                        <div class="col sc-2" data-label="Lecturer Name">John Doe</div>
                        <div class="col sc-3" data-label="Class Name">$350</div>
                        <div class="col sc-4" data-label="Subject Code">Pending</div>
                        <div class="col sc-5" data-label="Location">Pending</div>
                        <div class="col sc-6" data-label="Day">Pending</div>
                        <div class="col sc-7" data-label="Time">Pending</div>
                        <div class="col sc-8" data-label="Action">Pending</div>
                    </li>
                </ul>
            </div> -->
        </div>
    </body>
</html>