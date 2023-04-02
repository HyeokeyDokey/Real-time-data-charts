<!DOCTYPE html>
<html>
<head>
	<title>실시간 그래프 변형</title>
</head>
<body>
	<h1>실시간 그래프 변형</h1>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<?php for ($i = 1; $i <= 5; $i++) { ?>
		<label>데이터(toping) <?php echo $i; ?>:</label>
		<input type="text" name="data[<?php echo $i; ?>]" required><br><br>
		<label>데이터 양(amount of) <?php echo $i; ?>:</label>
		<input type="text" name="amount[<?php echo $i; ?>]" required><br><br>
		<?php } ?>
		<input type="submit" value="제출">
	</form>
	<?php
	// 데이터베이스 연결 정보 정의
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "myDB";

	// 데이터베이스 연결
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// 폼이 제출되면 데이터를 처리하는 코드
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    // 데이터 가져오기 및 필터링
	    $data = $_POST["data"];
	    $amount = $_POST["amount"];
	    $success_count = 0;

	    // 한 번에 5개의 데이터를 처리하는 for 루프
	    for ($i = 1; $i <= 5; $i++) {
	        $data1 = mysqli_real_escape_string($conn, $data[$i]);
	        $data2 = mysqli_real_escape_string($conn, $amount[$i]);
	        $sql = "INSERT INTO pizza (toping, amount) VALUES ('$data1', '$data2')";
	        if ($conn->query($sql) === TRUE) {
	            $success_count++;
	        } else {
	            echo "데이터 입력에 실패하였습니다.: " . $conn->error;
	        }
	    }

	    // 모든 데이터가 성공적으로 입력되었을 경우 메시지 출력
	    if ($success_count == 5) {
	        echo "모든 데이터가 성공적으로 입력되었습니다.";
	    }
	}

	// 데이터베이스 연결 종료
	$conn->close();
	?>
</body>
</html>