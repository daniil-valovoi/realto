<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

$defaultPassword = 'password123';
$hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

$firstNames = [
    'Jane', 'Michael', 'Emily', 'William', 'Olivia', 'James', 'Sophia', 'Liam',
    'Ava', 'Noah', 'Ethan', 'Isabella', 'Lucas', 'Mia', 'Benjamin', 'Charlotte',
    'Alexander', 'Amelia', 'Daniel', 'Harper', 'Henry', 'Evelyn', 'Sebastian', 'Abigail',
    'Logan', 'Ella', 'Matthew', 'Chloe', 'David', 'Grace', 'Jackson', 'Victoria'
];

$lastNames = [
    'Smith', 'Johnson', 'Davis', 'Brown', 'Jones', 'Garcia', 'Martinez', 'Hernandez',
    'Lopez', 'Wilson', 'Miller', 'Taylor', 'Anderson', 'Thomas', 'Jackson', 'White',
    'Harris', 'Clark', 'Lewis', 'Robinson', 'Walker', 'Hall', 'Allen', 'Young',
    'King', 'Wright', 'Scott', 'Torres', 'Nguyen', 'Hill', 'Flores', 'Green'
];

$domains = [
    'gmail.com',
    'yahoo.com',
    'outlook.com',
    'hotmail.com',
    'icloud.com',
    'webmail.com'
];

$mockUsers = [
    [
        'role_id' => 2,
        'first_name' => 'Administrator',
        'last_name' => 'Admin',
        'profile_picture' => 'default.png',
        'email' => 'admin@gmail.com',
        'password' => $hashedPassword,
        'phone' => '+12135550100'
    ],
    [
        'role_id' => 1,
        'first_name' => 'Test',
        'last_name' => 'User',
        'profile_picture' => 'default.png',
        'email' => 'test@test.com',
        'password' => $hashedPassword,
        'phone' => '+12135550101'
    ]
];

$usedEmails = ['admin@gmail.com', 'test@test.com'];
$dynamicUsersCount = 24;

for ($i = 0; $i < $dynamicUsersCount; $i++) {
    $firstName = $firstNames[array_rand($firstNames)];
    $lastName = $lastNames[array_rand($lastNames)];
    $domain = $domains[array_rand($domains)];

    $cleanFirst = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $firstName));
    $cleanLast = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $lastName));
    $email = "{$cleanFirst}.{$cleanLast}@{$domain}";

    if (in_array($email, $usedEmails, true)) {
        $email = "{$cleanFirst}.{$cleanLast}" . rand(1, 999) . "@{$domain}";
    }
    $usedEmails[] = $email;

    $mockUsers[] = [
        'role_id' => 1,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'profile_picture' => 'default.png',
        'email' => $email,
        'password' => $hashedPassword,
        'phone' => '+121' . rand(30000000, 99999999)
    ];
}

$createdCount = 0;
$updatedCount = 0;

echo "--- Populating Users ---<br>\n";

foreach ($mockUsers as $user) {
    try {
        $existingUserId = fetchData(
            'SELECT user_id FROM users WHERE email = ?',
            ['s', $user['email']],
            'user_id'
        );

        if ($existingUserId) {
            // Update password hash and phone if user already exists
            updateData(
                'UPDATE users SET password = ?, phone = ?, role_id = ? WHERE user_id = ?',
                ['ssii', $user['password'], $user['phone'], $user['role_id'], $existingUserId]
            );
            $updatedCount++;
            echo "Updated existing user: {$user['email']} (ID: {$existingUserId})<br>\n";
        } else {
            // Insert new user
            $insertQuery = '
                INSERT INTO users (role_id, first_name, last_name, profile_picture, email, password, phone)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ';
            $newUserId = insertData($insertQuery, [
                'issssss',
                $user['role_id'],
                $user['first_name'],
                $user['last_name'],
                $user['profile_picture'],
                $user['email'],
                $user['password'],
                $user['phone']
            ]);
            $createdCount++;
            echo "Created user: {$user['email']} (ID: {$newUserId})<br>\n";
        }
    } catch (Exception $e) {
        echo "Error processing user {$user['email']}: " . $e->getMessage() . "<br>\n";
    }
}

echo "<br>\nSummary: Created {$createdCount} users, updated {$updatedCount} users. Default password for all: <strong>{$defaultPassword}</strong><br>\n";
