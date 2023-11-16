<?php

class UserDataHandler {
    private $user_data = [];

    public function validateAndAddUser($username, $email, $age) {
        // Validate username
        if (!$this->isValidUsername($username)) {
            return "Invalid username";
        }

        // Validate email
        if (!$this->isValidEmail($email)) {
            return "Invalid email";
        }

        // Validate age
        if (!$this->isValidAge($age)) {
            return "Invalid age";
        }

        // Check for duplicate entries
        if ($this->isDuplicate($username, $email)) {
            return "Duplicate entry";
        }

        // Validate username length
        if (!$this->isValidUsernameLength($username)) {
            return "Invalid username length";
        }

        // Validate email length
        if (!$this->isValidEmailLength($email)) {
            return "Invalid email length";
        }

        // Validate age length
        if (!$this->isValidAgeLength($age)) {
            return "Invalid age length";
        }

        // Validate username
        if (!$this->isValidUsername($username)) {
            return "Invalid username";
        }

        // Validate email
        if (!$this->isValidEmail($email)) {
            return "Invalid email";
        }

        // Validate age
        if (!$this->isValidAge($age)) {
            return "Invalid age";
        }

        // Check for duplicate entries
        if ($this->isDuplicate($username, $email)) {
            return "Duplicate entry";
        }

        // If all validations pass, add the user
        $user = ["username" => $username, "email" => $email, "age" => $age];
        $this->user_data[] = $user;
        return "User added successfully";
    }

    private function isValidUsername($username) {
        // Perform username validation (hypothetical example)
        return preg_match("/^[a-zA-Z0-9_-]{3,15}$/", $username);
    }

    private function isValidEmail($email) {
        // Perform email validation (hypothetical example)
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isValidAge($age) {
        // Perform age validation (hypothetical example)
        return is_numeric($age) && $age > 0 && $age < 150;
    }

    private function isDuplicate($username, $email) {
        // Check for duplicate entries based on username and email
        foreach ($this->user_data as $user) {
            if ($user["username"] === $username || $user["email"] === $email) {
                return true;
            }
        }
        return false;
    }

    private function isValidUsernameLength($username) {
        // Perform username length validation (hypothetical example)
        $min_length = 3;
        $max_length = 15;
        return strlen($username) >= $min_length && strlen($username) <= $max_length;
    }

    private function isValidEmailLength($email) {
        // Perform email length validation (hypothetical example)
        $max_length = 255;
        return strlen($email) <= $max_length;
    }

    private function isValidAgeLength($age) {
        // Perform age length validation (hypothetical example)
        return strlen($age) <= 3; // Assuming a reasonable maximum age length
    }
}

// Example usage:
$dataHandler = new UserDataHandler();

// Attempt to add a user with valid data
$result1 = $dataHandler->validateAndAddUser("john_doe", "john@example.com", 25);
echo $result1 . PHP_EOL; // Output: "User added successfully"

// Attempt to add a user with duplicate email
$result2 = $dataHandler->validateAndAddUser("jane_doe", "john@example.com", 30);
echo $result2 . PHP_EOL; // Output: "Duplicate entry"

// Attempt to add a user with invalid age
$result3 = $dataHandler->validateAndAddUser("alice_smith", "alice@example.com", "twenty-five");
echo $result3 . PHP_EOL; // Output: "Invalid age"

// Attempt to add a user with valid data
$result4 = $dataHandler->validateAndAddUser("john_doe", "john@example.com", 25);
echo $result4 . PHP_EOL; // Output: "User added successfully"

// Attempt to add a user with an invalid username length
$result5 = $dataHandler->validateAndAddUser("a", "jane@example.com", 30);
echo $result5 . PHP_EOL; // Output: "Invalid username length"

// Attempt to add a user with an invalid email length
$result6 = $dataHandler->validateAndAddUser("alice_smith", str_repeat("a", 256), 28);
echo $result6 . PHP_EOL; // Output: "Invalid email length"

// Attempt to add a user with an invalid age length
$result7 = $dataHandler->validateAndAddUser("bob_jones", "bob@example.com", "one hundred");
echo $result7 . PHP_EOL; // Output: "Invalid age length"
?>
