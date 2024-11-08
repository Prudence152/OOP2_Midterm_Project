<?php

class Main {

    private EmployeeRoster $roster;
    private $size;
    private $repeat;

    public function __construct() {
        $this->roster = new EmployeeRoster();
    }

    public function start() {
        $this->clear();
        $this->repeat = true;

        $this->size = (int)readline("Enter the size of the roster: ");

        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
        } else {
            $this->entrance();
        }
    }

    public function entrance() {
        $choice = 0;

        while ($this->repeat) {
            $this->clear();
            $this->menu();
            $choice = (int)readline("Select an option: ");

            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    $this->repeat = false;
                    echo "Process terminated.\n";
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    break;
            }
        }
    }

    public function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    public function addMenu() {
        if ($this->roster->count() >= $this->size) {
            echo "Roster is full.\n";
            readline("Press \"Enter\" key to continue...");
            return;
        }

        $name = readline("Enter Employee Name: ");
        $address = readline("Enter Address: ");
        $age = (int)readline("Enter Age: ");
        $companyName = readline("Enter Company Name: ");

        $this->empType($name, $address, $age, $companyName);
    }

    public function empType($name, $address, $age, $companyName) {
        $this->clear();
        echo "---Employee Details--- \n";
        echo "Name: $name\n";
        echo "Address: $address\n";
        echo "Company: $companyName\n";
        echo "Age: $age\n";
        echo "[1] Commission Employee   [2] Hourly Employee   [3] Piece Worker\n";
        $type = (int)readline("Type of Employee: ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $companyName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $companyName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $companyName);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->empType($name, $address, $age, $companyName);
                break;
        }
    }

    public function addOnsCE($name, $address, $age, $companyName) {
        $sales = (float)readline("Enter total sales: ");
        $commissionRate = (float)readline("Enter commission rate: ");
        $employee = new CommissionEmployee($name, $address, $age, $companyName, $sales, $commissionRate);
        $this->roster->addEmployee($employee);
        $this->repeat();
    }

    public function addOnsHE($name, $address, $age, $companyName) {
        $hourlyRate = (float)readline("Enter hourly rate: ");
        $hoursWorked = (float)readline("Enter hours worked: ");
        $employee = new HourlyEmployee($name, $address, $age, $companyName, $hourlyRate, $hoursWorked);
        $this->roster->addEmployee($employee);
        $this->repeat();
    }

    public function addOnsPE($name, $address, $age, $companyName) {
        $piecesProduced = (int)readline("Enter number of pieces produced: ");
        $ratePerPiece = (float)readline("Enter rate per piece: ");
        $employee = new PieceWorker($name, $address, $age, $companyName, $piecesProduced, $ratePerPiece);
        $this->roster->addEmployee($employee);
        $this->repeat();
    }

    public function deleteMenu() {
        $this->clear();
        echo "***List of Employees on the Current Roster***\n";
        $this->roster->displayAllEmployees();

        $id = (int)readline("Enter the ID of the employee to delete or 0 to return: ");
        if ($id === 0) {
            return;
        }
        
        $deleted = $this->roster->deleteEmployeeById($id);
        if ($deleted) {
            echo "Employee deleted successfully.\n";
        } else {
            echo "Employee not found.\n";
        }
        readline("Press \"Enter\" key to continue...");
    }

    public function otherMenu() {
        $this->clear();
        echo "[1] Display Employees\n";
        echo "[2] Count Employees\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->displayMenu();
                break;
            case 2:
                $this->countMenu();
                break;
            case 3:
                $this->payrollMenu();
                break;
            case 0:
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                break;
        }
    }

    public function displayMenu() {
        $this->clear();
        echo "[1] Display All Employees\n";
        echo "[2] Display Commission Employees\n";
        echo "[3] Display Hourly Employees\n";
        echo "[4] Display Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->roster->displayAllEmployees();
                break;
            case 2:
                $this->roster->displayCommissionEmployees();
                break;
            case 3:
                $this->roster->displayHourlyEmployees();
                break;
            case 4:
                $this->roster->displayPieceWorkers();
                break;
            case 0:
                return;
            default:
                echo "Invalid input.\n";
                break;
        }
        readline("\nPress \"Enter\" key to continue...");
    }

    public function countMenu() {
        $this->clear();
        echo "[1] Count All Employees\n";
        echo "[2] Count Commission Employees\n";
        echo "[3] Count Hourly Employees\n";
        echo "[4] Count Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                echo "Total Employees: " . $this->roster->count() . "\n";
                break;
            case 2:
                echo "Commission Employees: " . $this->roster->countCommissionEmployees() . "\n";
                break;
            case 3:
                echo "Hourly Employees: " . $this->roster->countHourlyEmployees() . "\n";
                break;
            case 4:
                echo "Piece Workers: " . $this->roster->countPieceWorkers() . "\n";
                break;
            case 0:
                return;
            default:
                echo "Invalid input.\n";
                break;
        }
        readline("\nPress \"Enter\" key to continue...");
    }

    public function payrollMenu() {
        $this->clear();
        echo "Total Payroll: " . $this->roster->calculateTotalPayroll() . "\n";
        readline("\nPress \"Enter\" key to continue...");
    }

    public function clear() {
        system('clear');
    }

    public function repeat() {
        echo "Employee added!\n";
        if ($this->roster->count() < $this->size) {
            $c = readline("Add more? (y to continue): ");
            if (strtolower($c) == 'y') {
                $this->addMenu();
            } else {
                $this->entrance();
            }
        } else {
            echo "Roster is full\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    }
}
