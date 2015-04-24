<?php
	require 'aws/autoload.php';

	use Aws\DynamoDb\DynamoDbClient;
	use Aws\DynamoDb\Session\SessionHandler;

	$dynamoDb = DynamoDbClient::factory(array(
		'key'    => 'AKIAJJVAZP326VCBYSTQ',
		'secret' => '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',
		'region' => 'sa-east-1', // são paulo
		//'region' => 'us-east-1', // virginia
	));

	$sessionHandler = SessionHandler::factory(array(
		'dynamodb_client' => $dynamoDb,
		'table_name'      => 'sessions',
		'session_lifetime'         => 3600,
	));

	//$sessionHandler->createSessionsTable(5, 5);

	$sessionHandler->register();
?>