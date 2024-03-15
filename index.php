<?php
declare(strict_types = 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

echo "<style>
body {
    background-color: #333;
    color: whitesmoke;
}
</style>
<body>
    <h1>Nicole-Rene Newcomb's INF653 Midterm Project</h1>
</body>";