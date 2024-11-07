<?php

class EmployeeRoster {
    private array $roster;

    public function __construct($rosterSize) {
        $this->roster = array();
        echo "Roster initialized with capacity: $rosterSize\n";
    }

    public function add(Employee $employee) {
        
        if ($this->hasEmployeeWithName($employee->getName())) {
            echo "An employee with the name '{$employee->getName()}' already exists.\n";
        } else {
            $this->roster[] = $employee;
            echo "Employee added successfully.\n";
        }
    }

    public function hasEmployeeWithName($name): bool {
        foreach ($this->roster as $employee) {
            if ($employee->getName() === $name) {
                return true;  
            }
        }
        return false;  
    }

    public function remove($index) {
        if (isset($this->roster[$index])) {
            unset($this->roster[$index]);
            $this->roster = array_values($this->roster); 
            echo "Employee removed.\n";
        } else {
            echo "Invalid index.\n";
        }
    }

    public function count(): int {
        return count($this->roster);
    }

    public function display() {
        foreach ($this->roster as $employee) {
            echo $employee . "\n";
        }
    }

    public function payroll() {
        foreach ($this->roster as $employee) {
            echo $employee->getName() . " - Earnings: $" . $employee->earnings() . "\n";
        }
    }
}
