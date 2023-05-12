<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table class="styled-table">

    <thead>

        <tr>

    <!-- tr is a row, th is the header, add or remove this to see changes on column header -->

            <th>Email</th>

            <th>Name</th>

            <th>Phone</th>

        </tr>

    </thead>

    <tbody>

<!-- start here -->

<!-- start here -->

  

  <!-- You will input your dynamo code here.....research on php + dynamo -->

  <!-- tr stands for table row, and td for description..... this will need to be dynamic -->

        <?php

                    require 'vendor/autoload.php';

                    require_once('.env.php');




                    // Set up AWS SDK for PHP

                    

                    use Aws\DynamoDb\Marshaler;

                    use Aws\Credentials\CredentialProvider;

                    use Aws\DynamoDb\DynamoDbClient;

                    use Aws\Sts\StsClient;

                    use Aws\Credentials\AssumeRoleCredentialProvider;




                    $access_key_id = getenv('ACCESS_KEY_ID');

                    $iam_role = getenv('IAM_ROLE');

                    $secret_access_key = getenv('SECRET_ACCESS_KEY');




                    //Create an STS client with your AWS credentials

                    $stsClient = new StsClient([

                        'region' => 'us-east-1',

                        'version' => 'latest',

                        'credentials' => [

                            'key' => $access_key_id,

                            'secret' => $secret_access_key,

                        ],

                    ]);




                    // Specify ARN of IAM role

                    $roleArn = $iam_role;




                    // Specify the ARN of the source IAM user or role

                    // $sourceArn = 'arn:aws:iam::090049313008:user/hervieboy';




                    // $assumeRoleParams = [

                    //   'RoleArn' => $roleArn,

                    //   'RoleSessionName' => 'dynamo',

                    // ];




                    // Call the AssumeRole API action, passing in the role ARN and source ARN

                    $result = $stsClient->assumeRole([

                      'RoleArn' => $roleArn,

                      'RoleSessionName' => 'dynamo',

                      'DurationSeconds' => 3600,

                      

                    ]);




                    $credentials = $result->get('Credentials');




                    

                    

                    // Create a DynamoDB client with the temporary credentials

                    $dynamoDbClient = new DynamoDbClient([

                      'region' => 'us-east-1',

                      'version' => 'latest',

                      // 'credentials' => $assumeRoleProvider,

                      'credentials' => [

                        'key' => $credentials['AccessKeyId'],

                        'secret' => $credentials['SecretAccessKey'],

                        'token' => $credentials['SessionToken'],

                        ],

                    ]);

                    





                    $client = $dynamoDbClient;

                    // $tableName = 'GuestBook';




                    

                    // this converts output from AWS into arrays to extract your data

                    $marshaler = new Marshaler();




                    $params = [

                        'TableName' => 'GuestBook',

                    ];




                    $answer = $client->scan($params);




                    foreach ($answer['Items'] as $item) {

                        $record = $marshaler->unmarshalItem($item);

                        // Display the guest in the table

                        echo '<tr>';

                        echo '<td>' .$record['Email'] . '</td>';

                        echo '<td>' .$record['Name'] . '</td>';

                        echo '<td>' .$record['Phone'] . '</td>';

                        echo '</tr>';

                        //print_r($record);

                    }

                    

                   




                

                ?>




                        

    <!-- the end of your dynamo pickups -->





    </tbody>

</table>
</body>
</html>