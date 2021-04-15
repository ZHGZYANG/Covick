<?php
//mode 1: feedback
//mode 2: login
//mode 3: feedback review

// * db named zzy and collection named feedback must have been on the server


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 1) {
            if (isset($_POST['name']) && isset($_POST['feedback'])) {
                $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                // query
                //$query = new MongoDB\Driver\Query(array('age' == 30));
                //// Output of the executeQuery will be object of MongoDB\Driver\Cursor class
                //$cursor = $manager->executeQuery('zzy.feedback', $query);
                //print_r($cursor->toArray());

                // insert
                $bulk = new MongoDB\Driver\BulkWrite;
                $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

                $reply = true;
                $email = "NA";
                if (isset($_POST['reply'])) {
                    $reply = true;
                } else {
                    $reply = false;
                }
                if (isset($_POST['email'])) {
                    $email = $_POST['email'];
                }
                $document = array(
                    "_id" => new MongoDB\BSON\ObjectID,
                    "name" => $_POST['name'],
                    "feedback" => $_POST['feedback'],
                    "reply" => $reply,
                    "email" => $email,
                );

                $_id = $bulk->insert($document);
                //var_dump($_id);
                $result = $manager->executeBulkWrite('zzy.feedback', $bulk, $writeConcern);
                echo "Your feedback has been submitted.";
            } else {
                echo 'All fields are required!';
                header('HTTP/1.1 400 Bad Request');
            }
        } else if ($_GET['mode'] == 2) {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                if ($_POST['username'] == "test" && $_POST['password'] == "pass") {
                    setcookie('username', $_POST['username']);
                    setcookie('usertoken', 'thisisthetokenforuser_test');
                } else {
                    echo 'Username and password do not match';
                    header('HTTP/1.1 401 Unauthorized');
                }
            } else {
                echo 'All fields are required!';
                header('HTTP/1.1 400 Bad Request');
            }
        } else {
            echo 'Error mode!';
            header('HTTP/1.1 400 Bad Request');
        }
    } else {
        echo 'No mode set!';
        header('HTTP/1.1 400 Bad Request');
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 3) {
            if (isset($_GET['name'])) {
                $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                $filter = ['name' => ['$eq' => $_GET['name']]];
                $query = new MongoDB\Driver\Query($filter);
                $cursor = $manager->executeQuery('zzy.feedback', $query);
                $list=$cursor->toArray();
                if(count($list)==0){
                    echo 'No record found!';
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
                echo 'All fields are required!';
                header('HTTP/1.1 400 Bad Request');
            }
        }else{
            echo 'Error mode!';
            header('HTTP/1.1 400 Bad Request');
        }
    }else {
        echo 'No mode set!';
        header('HTTP/1.1 400 Bad Request');
    }
} else {
    echo 'This page cannot be retrieved directly!';
    header('HTTP/1.1 400 Bad Request');
}

?>