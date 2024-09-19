<?php

class Validator {
    private $errors = []; // To store validation errors

    public function validateString($fieldName, $value, $minLength, $maxLength, $required = true) {
        $value = trim($value);

        if (!$required && empty($value)) {
            return null; // Skip validation for optional and empty fields
        }

        if ($required && empty($value)) {
            $this->errors[$fieldName] = "$fieldName is required.";
            return null;
        }

        if(strlen($value) < $minLength) {
            $this->errors[$fieldName] = "$fieldName must have at least $minLength characters.";
            return null;
        }

        if (strlen($value) > $maxLength) {
            $this->errors[$fieldName] = "$fieldName must not exceed $maxLength characters.";
            return null;
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // Sanitized value
    }

    
    public function validateNumeric($fieldName, $value, $min = null, $max = null, $required = true) {
        $value = trim($value);

        if (!$required && empty($value)) {
            return null; // Skip validation for optional and empty fields
        }

        if ($required && empty($value)) {
            $this->errors[$fieldName] = "$fieldName is required.";
            return null;
        }

        if (!is_numeric($value)) {
            $this->errors[$fieldName] = "$fieldName must be a numeric value.";
            return null;
        }

        $value = intval($value); 
        if ($min !== null && $value < $min) {
            $this->errors[$fieldName] = "$fieldName must be at least $min.";
            return null;
        }

        if ($max !== null && $value > $max) {
            $this->errors[$fieldName] = "$fieldName must not exceed $max.";
            return null;
        }

        return intval($value);
    }

    public function validateEmail($fieldName, $value, $required = true, $minLength = 8, $maxLength = 75) {
        $value = trim($value);

        if (!$required && empty($value)) {
            return null; // Skip validation for optional and empty fields
        }

        if ($required && empty($value)) {
            $this->errors[$fieldName] = "$fieldName is required.";
            return null;
        }

        if(strlen($value) < $minLength) {
            $this->errors[$fieldName] = "$fieldName must have at least $minLength characters.";
            return null;
        }

        if (strlen($value) > $maxLength) {
            $this->errors[$fieldName] = "$fieldName must not exceed $maxLength characters.";
            return null;
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$fieldName] = "$fieldName must be a valid email address.";
            return null;
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    
    public function validateSelection($fieldName, $value, $allowedValues, $required = true) {
        $value = trim($value);

        if (!$required && empty($value)) {
            return null; // Skip validation for optional and empty fields
        }

        if ($required && empty($value)) {
            $this->errors[$fieldName] = "$fieldName is required.";
            return null;
        }

        if (!in_array($value, $allowedValues)) {
            $this->errors[$fieldName] = "$fieldName has an invalid value.";
            return null;
        }

        return $value;
    }

    public function validateFiles($fieldName, $filesArray, $minFiles, $maxFiles, $allowedTypes = null, $maxSize = 7) {
        $maxSize = $maxSize * 1024 * 1024;
        if ($allowedTypes === null) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        }

        $amount = count($filesArray['tmp_name']); // Correct count for file array
        
        if ($amount < $minFiles) {
            $this->errors[$fieldName] = "At least $minFiles files must be uploaded.";
            return null;
        }
    
        if ($amount > $maxFiles) {
            $this->errors[$fieldName] = "No more than $maxFiles files can be uploaded.";
            return null;
        }
    
        $validatedFiles = [];
    
        foreach($filesArray['tmp_name'] as $index => $tmpName) {
            $fileType = $filesArray['type'][$index];  // MIME type, e.g., image/jpeg
            $fileSize = $filesArray['size'][$index];
            $fileError = $filesArray['error'][$index];
    
            // Validate file type against allowed types
            if (!in_array($fileType, $allowedTypes)) {
                $this->errors[$fieldName][$index] = "File $index has an invalid format.";
            }
    
            // Validate file size
            if ($fileSize > $maxSize) {
                $this->errors[$fieldName][$index] = "File $index exceeds the maximum size of " . ($maxSize / 1024 / 1024) . "MB.";
            }
    
            // Check for upload errors
            if ($fileError !== UPLOAD_ERR_OK) {
                $this->errors[$fieldName][$index] = "File $index failed to upload.";
            }
    
            // If there are no errors for this file, add it to validated files
            if (!isset($this->errors[$fieldName][$index])) {
                $validatedFiles[] = $tmpName;  // Add the tmp_name to validated files
            }
        }
    
        // If there are any validation errors, return null
        if (!empty($this->errors[$fieldName])) {
            return null;
        }
    
        return $validatedFiles;  // Return the validated files array
    }
    
    

    public function validateFile($fieldName, $file, $allowedTypes = null, $maxSize = 2) {
        $maxSize = $maxSize * 1024 * 1024;
        if ($allowedTypes === null) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        }
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[$fieldName] = "Error uploading file." . ($file['error'] ?? 'unknown');
            return null;
        }

        if (!in_array($file['type'], $allowedTypes)) {
            $this->errors[$fieldName] = "$fieldName has an invalid file type.";
            return null;
        }

        if ($file['size'] > $maxSize) {
            $this->errors[$fieldName] = "$fieldName exceeds the maximum allowed size.";
            return null;
        }

        return $file;
    }

    public function validateMainImage($fieldName, $validatedImages, $mainImageIndex) {
        if(!isset($validatedImages[$mainImageIndex])) {
            die("Invalid main image index.");
        }
        foreach($validatedImages as $index=>$image) {
            if($index === $mainImageIndex) {
                return $mainImageIndex;
            }
        }
        $this->errors[$fieldName] = "$fieldName is not set/upload failed.";
        return null;
    }

    
    public function hasErrors() {
        return !empty($this->errors);
    }

    
    public function getErrors() {
        return $this->errors;
    }

    
    public function clearErrors() {
        $this->errors = [];
    }
}

