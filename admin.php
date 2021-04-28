<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>COVICK - Feedback List</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

    <script src="base.js"></script>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="headpage"></div>

<div class="mainbody">
    <?php
        if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken']=='thisisthetokenforuser_test') {
            $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query(array());
            $cursor = $manager->executeQuery('zzy.feedback', $query);
            $list=$cursor->toArray();
            if(count($list)==0){
                print '<div class="center"><h1>There is no any feedback currently, please check later.</h1><br><h6>You can add feedback under <a href="about.html">About</a> page.</h6></div>';
            }else{
                print "<div class=\"content container-fluid\">
                            <table class=\"table table-striped table-hover\">
                                <thead class=\"thead-dark\">
                                <tr>
                                    <th class=\"align-middle\" id=\"tablehead\" colspan=\"4\">Feedback List</th>
                                </tr>";
                print "<tr>
                        <th>Name</th>
                        <th>Feedback</th>
                        <th>Need Reply</th>
                        <th>Email</th>
                    </tr></thead><tbody>";

                foreach($list as $item){
                    $name=$item->name;
                    $feedback=$item->feedback;
                    $reply=$item->reply;
                    $email=$item->email;
                    if($reply==true){
                        $reply="true";
                    }else{
                        $reply="false";
                    }
                    if($email=="")
                        $email="NA";
                    print "<tr><td>".$name."</td><td>".$feedback."</td><td>".$reply."</td><td>".$email."</td></tr>";
                }
                print "</tbody></table></div>";
            }
        } else {
            print '<div class="center"><h1>Please sign in.</h1></div>';
        }

    ?>
</div>

<!--footer-->
<div class="footpage"></div>
<!--footer over-->
</body>
</html>