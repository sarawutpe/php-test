<?php
class Services
{
	private $db;

	function __construct()
	{
		$servername = "j3s.h.filess.io";
		$username = "empdb_labellike";
		$password = "483873a379dfd2d64b825f12188aa90a35dda5a9";
		$database = "empdb_labellike";
		$port = 3305;

		try {
			// Create a connection
			$this->db = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
			// Set PDO error mode to exception
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
	}

	public function login()
	{
		// Get json
		$contents = file_get_contents('php://input');
		$req = json_decode($contents);

		$email = $req->email ?? null;
		$password = $req->password ?? null;

		if ($email === 'admin@example.com' && $password === '1234') {
			$_SESSION['isloggedin'] = true;

			http_response_code(200);
			echo json_encode("");
		} else {
			http_response_code(401);
			echo json_encode("");
		}
	}

	public function logout()
	{
		$_SESSION['isloggedin'] = false;
	}

	public function createEmployee()
	{
		try {
			$res = new stdClass();
			// Get json
			$contents = file_get_contents('php://input');
			$req = json_decode($contents);

			$name = $req->name ?? null;
			$salary = $req->salary ?? null;
			$dateEmployed = $req->dateEmployed ?? null;
			$position = $req->position ?? null;
			$status = $req->status ?? null;

			// Check for null or empty values
			if (empty($name) || empty($salary) || empty($dateEmployed) || empty($position) || $status === null) {
				$res->success = false;
				$res->error = "Missing required fields";
				echo json_encode($res);
				return;
			}

			$sql = "INSERT INTO employees (name, salary, dateEmployed, position, status) VALUES (:name, :salary, :dateEmployed, :position, :status)";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([
				'name' => $name,
				'salary' => $salary,
				'dateEmployed' => $dateEmployed,
				'position' => $position,
				'status' => $status
			]);

			$res->success = true;
			echo json_encode($res);
		} catch (PDOException $e) {
			$res = new stdClass();
			$res->success = false;
			$res->error = $e->getMessage();
			echo json_encode($res);
		}
	}

	public function getEmployee()
	{
		try {
			$res = new stdClass();

			$q = isset($_GET['q']) ? trim($_GET['q']) : '';
			// filter flag and additional flags 
			$q = filter_var($q, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

			$sql = "SELECT * FROM employees WHERE name LIKE :q ORDER BY timestamp DESC";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(
				[
					'q' => '%' . $q . '%',
				]
			);

			$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$res->success = true;
			$res->data = $employees;

			echo json_encode($res);
		} catch (PDOException $e) {
			$res = new stdClass();
			$res->success = false;
			$res->error = $e->getMessage();
			echo json_encode($res);
		}
	}

	public function updateEmployee($id)
	{
		try {
			$res = new stdClass();

			// Get json
			$contents = file_get_contents('php://input');
			$req = json_decode($contents);

			$name = $req->name ?? null;
			$salary = $req->salary ?? null;
			$dateEmployed = $req->dateEmployed ?? null;
			$position = $req->position ?? null;
			$status = $req->status ?? null;

			// Check for null or empty values
			if (empty($name) || empty($salary) || empty($dateEmployed) || empty($position) || $status === null) {
				$res->success = false;
				$res->error = "Missing required fields";
				echo json_encode($res);
				return;
			}

			$sql = "UPDATE employees SET name = :name, salary = :salary, dateEmployed = :dateEmployed, position = :position, status = :status WHERE id = :id";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([
				'name' => $name,
				'salary' => $salary,
				'dateEmployed' => $dateEmployed,
				'position' => $position,
				'status' => $status,
				'id' => $id
			]);

			if ($stmt->rowCount() === 0) {
				$res->success = false;
				$res->message = "id $id Not Found.";
				echo json_encode($res);
				return;
			}

			$res->success = true;
			echo json_encode($res);
		} catch (PDOException $e) {
			$res = new stdClass();
			$res->success = false;
			$res->error = $e->getMessage();
			echo json_encode($res);
		}
	}

	public function deleteEmployee($id)
	{
		try {
			$res = new stdClass();
			$sql = "DELETE FROM employees WHERE id = :id";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([
				'id' => $id
			]);

			if ($stmt->rowCount() === 0) {
				$res->success = false;
				$res->message = "id $id Not Found.";
				echo json_encode($res);
				return;
			}

			$res->success = true;
			echo json_encode($res);
		} catch (PDOException $e) {
			$res = new stdClass();
			$res->success = false;
			$res->error = $e->getMessage();
			echo json_encode($res);
		}
	}
}
