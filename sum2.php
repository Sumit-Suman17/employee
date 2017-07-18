<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
/* * https://www.slimframework.com/
   * Require the Slim Framework using Composer's autoloader

*/
require '../vendor/autoload.php';
$app = new \Slim\App;
$app->group('/v1', function () use ($app) {
$app->post('/emp1', function($request) {
	$connection=mysqli_connect('localhost','root','','sumit');
	$query = "INSERT INTO employee (Emp_Id,Name,Age,salary,street,city,pin) VALUES (?,?,?,?,?,?,?)";
 
 $stmt = $connection->prepare($query);
 
 $stmt->bind_param("sssssss",$Emp_Id,$Name,$Age,$salary,$street,$city,$pin);
 
 $Emp_Id = $request->getParsedBody()['Emp_Id'];
 $Name = $request->getParsedBody()['Name'];
 $Age = $request->getParsedBody()['Age'];
 $salary = $request->getParsedBody()['salary'];
 $street = $request->getParsedBody()['street'];
 $city = $request->getParsedBody()['city'];
 $pin = $request->getParsedBody()['pin'];
 
  $stmt->execute();
	 
});
$app->get('/emp1', function (Request $request, Response $response) {
	$connection=mysqli_connect('localhost','root','','sumit');
 $query = "select Emp_Id,Name,Age,salary,CONCAT(street,',',city,',',pin) AS address from employee order by Emp_Id";
 
 
 $result = $connection->query($query);
 
 while ($row = $result->fetch_assoc()){
 
$data[] = $row;
 
 }
 
 echo json_encode($data);
 

});
$app->get('/emp1/{Emp_Id}', function ($request,$response) {
	$connection=mysqli_connect('localhost','root','','sumit');
  $Emp_Id = $request->getAttribute('Emp_Id');
 $query = "select Emp_Id,Name,Age,salary,CONCAT(street,',',city,',',pin) AS address from employee where Emp_Id=$Emp_Id";
 
 $result = $connection->query($query);
 
 while ($row = $result->fetch_assoc()){
 
$data[] = $row;
 
 }
 
 echo json_encode($data);
 

});
$app->put('/emp1/{Emp_Id}', function ( $request) {
	$connection=mysqli_connect('localhost','root','','sumit');
	$Emp_Id = $request->getAttribute('Emp_Id');
  
  $query = "UPDATE employee SET Emp_Id=?, Name = ?, Age = ? ,salary = ? ,street = ?, city= ?,pin= ? WHERE Emp_Id = $Emp_Id";
 
   $stmt = $connection->prepare($query);
 
   $stmt->bind_param("sssssss",$Emp_Id,$Name,$Age,$salary,$street,$city,$pin);
 
  $Emp_Id = $request->getParsedBody()['Emp_Id'];
 
    $Name = $request->getParsedBody()['Name'];
 
   $Age = $request->getParsedBody()['Age'];
   $salary = $request->getParsedBody()['salary'];
   $street = $request->getParsedBody()['street'];

   $city = $request->getParsedBody()['city'];
   $pin = $request->getParsedBody()['pin'];
 
   $stmt->execute();
   
   
	
  

});
$app->delete('/emp1/{Emp_Id}', function($request){
 $connection=mysqli_connect('localhost','root','','sumit');
 $Emp_Id = $request->getAttribute('Emp_Id');
 $query = "DELETE from employee WHERE Emp_Id = $Emp_Id";
 $result = $connection->query($query);
 if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>' Successfull.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>' Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	
});
});
$app->run();