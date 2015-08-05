<?php

// How many records do you want?
$maxRecords = 50000;

$config = parse_ini_file(realpath(__DIR__ . '/../../application/configs/application.ini'), getenv('APPLICATION_ENV'));
if (file_exists(__DIR__ . '/../../application/configs/local.ini')) {
    $localConfig = parse_ini_file(realpath(__DIR__ . '/../../application/configs/local.ini'));
}
$config = array_merge($config, $localConfig);

$dsn = sprintf(
    '%s:host=%s;port=%d;dbname=%s;encoding=utf8',
    'mysql',
    $config['resources.db.params.host'],
    $config['resources.db.params.port'],
    $config['resources.db.params.dbname']
);
$pdo = new PDO($dsn, $config['resources.db.params.username'], $config['resources.db.params.password']);

require_once 'autoload.php';
$faker = Faker\Factory::create();
$dateFormat = 'Y-m-d H:i:s';
$start = microtime(true);
for ($i = 0; $i < $maxRecords; $i++) {
    echo sprintf('%09d: Generating awesome data for you...', $i + 1);

    // User generation on the fly
    $user = array (
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'email' => $faker->email,
        'password' => $faker->password,
        'active' => ($faker->boolean() ? 1 : 0),
        'created' => $faker->dateTimeThisDecade->format($dateFormat),
        'modified' => $faker->dateTimeThisDecade->format($dateFormat),
    );
    insertInDb($pdo, $user, 'account');

    // Project generation on the fly
    $project = array (
        'accountId' => $faker->numberBetween(1, $maxRecords),
        'projectName' => $faker->realText(45),
        'created' => $faker->dateTimeThisDecade->format($dateFormat),
        'modified' => $faker->dateTimeThisDecade->format($dateFormat),
    );
    insertInDb($pdo, $project, 'project');

    // Project generation on the fly
    $task = array (
        'projectId' => $faker->numberBetween(1, $maxRecords),
        'accountId' => $faker->numberBetween(1, $maxRecords),
        'title' => $faker->realText(45),
        'description' => $faker->text,
        'dueDate' => $faker->dateTimeBetween('last year', 'next year')->format($dateFormat),
        'created' => $faker->dateTimeThisDecade->format($dateFormat),
        'modified' => $faker->dateTimeThisDecade->format($dateFormat),
        'done' => ($faker->boolean() ? 1 : 0),
    );
    insertInDb($pdo, $task, 'task');

    echo 'Done!' . PHP_EOL;
}
$stop = microtime(true);

echo PHP_EOL . sprintf('Total processing time: %s seconds.', round(($stop - $start), 2)) . PHP_EOL;

function insertInDb(PDO $pdo, array $data, $tableName) {
    $countDataFields = count($data);
    $dataSql = sprintf(
        'INSERT INTO %s (%s) VALUES (%s)',
        $tableName,
        implode(', ', array_keys($data)),
        str_repeat('?, ', $countDataFields - 1) . '?'
    );
    $stmt = $pdo->prepare($dataSql);
    $dataFields = array_values($data);
    for ($j = 0; $j < $countDataFields; $j++) {
        $stmt->bindParam($j + 1, $dataFields[$j]);
    }
    if (false === ($result = $stmt->execute())) {
        echo var_export($stmt->errorInfo(), true);
        echo 'Query: ' . $stmt->queryString . PHP_EOL;
        echo 'Bind params: ' . var_export($stmt->debugDumpParams(), true) . PHP_EOL;
    }
}