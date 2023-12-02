<?php
include "../../db_conn.php";
$recipients = $_POST['recipients'];
$message = $_POST['message'];

// residents
$residents = array();
$residentQuery = "SELECT phone_number FROM resident";

$residentStatement = $pdo->query($residentQuery);
$residentsNumber = $residentStatement->fetchAll(PDO::FETCH_ASSOC);
foreach ($residentsNumber as $resident) {

    if ($resident['phone_number'] != '')
        $residents[] = $resident['phone_number'];
}

// officials
$officials = array();
$officialQuery = "SELECT phone_number FROM resident, officials WHERE resident.occupation = officials.off_position";

$officialStatement = $pdo->query($officialsQuery);
$officialsNumber = $officialStatement->fetchAll(PDO::FETCH_ASSOC);

foreach ($officialsNumber as $official) {

    if ($official['phone_number'] != '')
        $officials[] = $official['phone_number'];
}


// Senior Citizen
$seniors = array();
$seniorQuery = "SELECT phone_number FROM resident WHERE resident.senior_status = :senior_status";
$seniorStatement = $pdo->prepare($seniorQuery);
$seniorStatement->bindValue(':senior_status', 'Senior Citizen');
$seniorStatement->execute();

while ($senior = $seniorStatement->fetch(PDO::FETCH_ASSOC)) {

    if ($senior['phone_number'] != '')
        $seniors[] = $senior['phone_number'];
}

// Person with Disability
$disabilities = array();
$disabilityQuery = "SELECT phone_number FROM resident WHERE resident.disability_status = :disability_status";
$disabilityStatement = $pdo->prepare($disabilityQuery);
$disabilityStatement->bindValue(':disability_status', 'Person with Disability');
$disabilityStatement->execute();

while ($disability = $disabilityStatement->fetch(PDO::FETCH_ASSOC)) {

    if ($disability['phone_number'] != '')
        $disabilities[] = $disability['phone_number'];
}

// Registered Voters
$voters = array();

$voterQuery = mysqli_query($conn, "SELECT phone_number FROM resident WHERE resident.voter_status = :voter_status");
$voterStatement = $pdo->prepare($voterQuery);
$voterStatement->bindValue(':voter_status', 'Registered Voter');
$voterStatement->execute();

while ($voter = $voterStatement->fetch(PDO::FETCH_ASSOC)) {

    if ($voter['phone_number'] != '')
        $voters[] = $voter['phone_number'];
}

//  <!-- phone numbers separated by "," -->
//  <?php $contacts = implode(', ', $variabele); 

$annInsert = "INSERT INTO `announcement`(
    `message`,
    `recipients`
    )
    VALUES (
    :message,
    :recipients
    )
";

$annStatement = $pdo->prepare($annInsert);
$annStatement->bindParam(':message', $message);
$annStatement->bindParam(':recipients', $recipients);
$annStatement->execute();


header("location:index.php");


// SEMAPHORE SMS API 
if ($recipients == 'All Residents') {

    $ch = curl_init();
    $parameters = array(
        'apikey' => 'dacf145e917a96dc0003f2a8eefb37e8', //API KEY 
        'number' => $contacts = implode(', ', $residents),
        'message' => $_POST['message'],
        'sendername' => 'SEMAPHORE'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);

    //Send the parameters set above with the request
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

    // Receive response FROM server
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    //Show the server response
    if (!$result) {
?>
        <script>
            alert('Message not sent!')
        </script>
    <?php
    } else {
        // echo $result;

    ?>
        <script>
            alert('Message sent!')
        </script>
    <?php
    }
}

if ($recipients == 'Barangay Officials') {

    $ch = curl_init();
    $parameters = array(
        'apikey' => 'dacf145e917a96dc0003f2a8eefb37e8', //API KEY 
        'number' => $contacts = implode(', ', $officials),
        'message' => $_POST['message'],
        'sendername' => 'SEMAPHORE'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);

    //Send the parameters set above with the request
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

    // Receive response from server
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    //Show the server response
    if (!$result) {
    ?>
        <script>
            alert('Message not sent!')
        </script>
    <?php
    } else {
        // echo $result;

    ?>
        <script>
            alert('Message sent!')
        </script>
    <?php
    }
}

if ($recipients == 'Senior Citizens') {

    $ch = curl_init();
    $parameters = array(
        'apikey' => 'dacf145e917a96dc0003f2a8eefb37e8', //API KEY 
        'number' => $contacts = implode(', ', $senior),
        'message' => $_POST['message'],
        'sendername' => 'SEMAPHORE'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);

    //Send the parameters set above with the request
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

    // Receive response from server
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    //Show the server response
    if (!$result) {
    ?>
        <script>
            alert('Message not sent!')
        </script>
    <?php
    } else {
        // echo $result;

    ?>
        <script>
            alert('Message sent!')
        </script>
    <?php
    }
}


if ($recipients == 'Persons with Disability') {

    $ch = curl_init();
    $parameters = array(
        'apikey' => 'dacf145e917a96dc0003f2a8eefb37e8', //API KEY 
        'number' => $contacts = implode(', ', $disability),
        'message' => $_POST['message'],
        'sendername' => 'SEMAPHORE'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);

    //Send the parameters set above with the request
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

    // Receive response from server
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    //Show the server response
    if (!$result) {
    ?>
        <script>
            alert('Message not sent!')
        </script>
    <?php
    } else {
        // echo $result;

    ?>
        <script>
            alert('Message sent!')
        </script>
    <?php
    }
}

if ($recipients == 'Registered Voters') {

    $ch = curl_init();
    $parameters = array(
        'apikey' => 'dacf145e917a96dc0003f2a8eefb37e8', //API KEY 
        'number' => $contacts = implode(', ', $voters),
        'message' => $_POST['message'],
        'sendername' => 'SEMAPHORE'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);

    //Send the parameters set above with the request
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

    // Receive response from server
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    //Show the server response
    if (!$result) {
    ?>
        <script>
            alert('Message not sent!')
        </script>
    <?php
    } else {
        // echo $result;

    ?>
        <script>
            alert('Message sent!')
        </script>
<?php
    }
}
?>