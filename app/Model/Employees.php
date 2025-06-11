<?php

class Employees extends Model
{
    protected $table = "employees";

    protected $allowed_columns = [
        'employeeNo', 'rfidNumber', 'firstName', 'lastName', 'dob',
        'placeOfBirth', 'sex', 'civilStatus', 'contactNumber', 'email',
        'citizenship', 'bloodType', 'position', 'address', 'baseSalary',
        'sssNumber', 'pagibigNumber', 'philhealthNumber', 'gsisNumber',
        'photo_path'
    ];

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllEmployees()
    {
        $query = "SELECT * FROM employees WHERE deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
