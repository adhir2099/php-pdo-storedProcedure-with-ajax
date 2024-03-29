<?php

include('./dbcon.php');

if(isset($_POST["action"])){

    //Load data
    if($_POST["action"] == "Load"){

        $statement = $connect->prepare("SELECT * FROM employees ORDER BY name ASC");
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table id="tech-companies-1" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Age</th>
                </tr>
            </thead>
            <tbody>
        ';

        if(sizeof($result) > 0){
            
            foreach($result as $row){
                $output .= '
                <tr>
                    <td>'.$row["name"].'</td>
                    <td>'.$row['address'].'</td>
                    <td>'.$row['gender'].'</td>
                    <td>'.$row['age'].'</td>
                </tr>';
            }
        }else{
            $output .= '
                <tr>
                    <td align="center">No se encontraron registros</td>
                </tr>';
        }

        $output .= '</tbody></table>';

        echo $output;

    }
}

//Create
if($_POST["action"] == "Save"){
    
    $name    = $_POST["name"];
    $address = $_POST["address"];
    $gender  = $_POST["gender"];
    $age     = $_POST["age"];

    $statement = $connect->prepare("CALL employeeInsert(:name, :address, :gender, :age)");
    $statement->bindParam(':name', $name);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':gender', $gender);
    $statement->bindParam(':age', $age);
    $result = $statement->execute();

    if(!empty($result)){
        echo 'recordInserted';
    }
}