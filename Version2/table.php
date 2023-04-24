<?php 
// fetch Data from AWS dynamoDB
require 'vendor/autoload.php';
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\Common\Aws;

 // Set up the client
 $client = DynamoDbClient::factory(
  array(
      'profile' => 'default',
      'region' => 'us-east-1',
      'version' => '2012-08-10',
  )
);

$tableName = "GuestBook";
$tableRows = '';

try {
  $result = $client->scan([
      'TableName' => $tableName
  ]);

  $items = $result['Items'];
} catch (DynamoDbException $e) {

  // If there's an error, show an error message in a table row that spans 3 columns
  header('HTTP/1.1 500 Internal Server Error');
  $tableRows = '<tr><td colspan="3" style="color:red;text-align:center;">
                  Error connecting to DynamoDB:<br> ' . $e->getMessage() . '</td></tr>';
  echo $tableRows;
  exit();
}

foreach ($items as $item) {
  $email = $item['Email']['S'];
  $country = $item['Country']['S'];
  $password = $item['Password']['S'];
  $name = $item['Name']['S'];
  $tableRows .= '<tr>' .
      '<td data-label="Email">' . $email . '</td>' .
      '<td data-label="Country">' . $country . '</td>' .
      '<td data-label="Password">'. $password . '</td>' .
      '<td data-label="name">' . $name . '</td>' .
      '</tr>';
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>List</title>
</head>
<body>
    <nav class="nav">
        <div class="nav-container nav-flex">
            <div id="branding"><h1>AZUBI v3</h1></div>
            <div class="profile">
                <a href="logout.php"><span class="padlock">🔒</span> Logout</a>
                
            </div>
        </div>
    </nav>
    <div class="table-container">
    <table>
  <caption>Student List</caption>
  <thead>
    <tr>
      <th scope="col">Email</th>
      <th scope="col">Country</th>
      <th scope="col"> Password</th>
      <th scope="col">Full Names</th>
    </tr>
  </thead>
  <tbody>
    <?php echo $tableRows; ?>
  </tbody>
</table>
        
    </div>
</body>
</html>