<?php
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class EmployeeRoster {
    private $roster;

    public function __construct($rosterSize) {
        $this->roster = array_fill(0, $rosterSize, null);
    }

    public function add(Employee $e) {
        for ($i = 0; $i < count($this->roster); $i++) {
            if ($this->roster[$i] === null) {
                $this->roster[$i] = $e;
                return true;
            }
        }
        return false;
    }

    public function remove($index) {
        if (isset($this->roster[$index])) {
            $this->roster[$index] = null;
            echo "Employee was successfully removed.\n";
            return true;
        }
        echo "Slot is empty.\n";
        return false;
    }

    public function count() {
        return count(array_filter($this->roster));
    }

    public function countCE() {
        return count(array_filter($this->roster, fn($e) => $e instanceof CommissionEmployee));
    }

    public function countHE() {
        return count(array_filter($this->roster, fn($e) => $e instanceof HourlyEmployee));
    }

    public function countPE() {
        return count(array_filter($this->roster, fn($e) => $e instanceof PieceWorker));
    }

    public function display() {
        foreach ($this->roster as $index => $employee) {
            if ($employee !== null) {
                echo "Employee #$index\n" . $employee->toString() . "\n\n";
            }
        }
    }

    public function displayCE() {
        $this->displayByType(CommissionEmployee::class);
    }

    public function displayHE() {
        $this->displayByType(HourlyEmployee::class);
    }

    public function displayPE() {
        $this->displayByType(PieceWorker::class);
    }

    private function displayByType($type) {
        foreach ($this->roster as $index => $employee) {
            if ($employee instanceof $type) {
                echo "Employee #$index\n" . $employee->toString() . "\n\n";
            }
        }
    }

    public function payroll() {
        foreach ($this->roster as $index => $employee) {
            if ($employee !== null) {
                echo "#$index\n" . $employee->toString() . ", Earnings: " . $employee->earnings() . "\n\n";
            }
        }
    }
}
?>
