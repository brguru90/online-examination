<?php
session_start();
if (!isset($_SESSION['admin']))
{
	header('Location:index.html');
}
include('db.php');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

//---------first time Admin login table creation----------
$sql = "create table admin_login
(
user VARCHAR(20) primary key,
pwd VARCHAR(20) NOT NULL
);";
$conn->query($sql);
$sql="insert into admin_login values('admin','12345');";
$conn->query($sql);
$sql="insert into admin_login values('guru','9611');";
$conn->query($sql);

//---------first time user login table creation----------
$sql = "create table login
(
name varchar(20) not null,
user VARCHAR(20) UNIQUE,
pwd VARCHAR(20) NOT NULL,
user_id varchar(10) primary key,
branch_code varchar(10) not null,
start_date INT(10) not null,
end_date INT(10) not null
);";
$conn->query($sql);
$sql="insert into login values('basavaraj','bassu','bassu@95','1da16cs400','cs',".date("dmY").",".(date("d")+6)."".date("mY").")";
$conn->query($sql);
$sql="insert into login values('Guruprasad','guru','9611','1da16cs404','cs',".date("dmY").",".(date("d")+6)."".date("mY").")";
$conn->query($sql);

//-----------------first time subject initialization-------------------
$sql = "create table subjects
(
sub_code varchar(6) primary key,
sub_name varchar(20) not null,
branch_code varchar(10) not null
);";
$conn->query($sql);
$sql="insert into subjects values('gk00','Generel knowledge','cs');";
$conn->query($sql);
$sql="insert into subjects values('cs00','c','cs');";
$conn->query($sql);
$sql="insert into subjects values('cs01','c++','cs');";
$conn->query($sql);
$sql="insert into subjects values('cs02','java','cs');";
$conn->query($sql);
$sql="insert into subjects values('cs03','web','cs');";
$conn->query($sql);
$sql="insert into subjects values('cs04','c#','cs');";
$conn->query($sql);
$sql="insert into subjects values('cs05','android','cs');";
$conn->query($sql);

/***********************Initialize some quetion for testing can be removed*************************/
$sql = "create table quiz
(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
que varchar(500) not null unique,
ans_list varchar(500) not null,
corr_ans INT,
subject_code varchar(10)
);";
$conn->query($sql);
$sql="select * from quiz";
$result=$conn->query($sql);
if ($result->num_rows < $number_of_quetions) {
	$sql="
		insert into quiz (que,ans_list,corr_ans,subject_code)
		values('which is A?','C_SePaRaTe_A_SePaRaTe_D_SePaRaTe_B',2,'gk00');
	";
	$conn->query($sql);
	$sql="
		insert into quiz (que,ans_list,corr_ans,subject_code)
		values('which is C?','C_SePaRaTe_A_SePaRaTe_D_SePaRaTe_B',1,'gk00');
	";
	$conn->query($sql);
	$sql="
		insert into quiz (que,ans_list,corr_ans,subject_code)
		values('which is D?','C_SePaRaTe_A_SePaRaTe_D_SePaRaTe_B',3,'gk00');
	";
	$conn->query($sql);
	$sql="
		insert into quiz (que,ans_list,corr_ans,subject_code)
		values('which is B?','C_SePaRaTe_A_SePaRaTe_D_SePaRaTe_B',4,'gk00');
	";
	$conn->query($sql);
	$sql="
		insert into quiz (que,ans_list,corr_ans,subject_code)
		values('which is your country?','INDIA_SePaRaTe_SHRILANKA_SePaRaTe_RUSSIA_SePaRaTe_JAPAN',1,'gk00');
	";
	$conn->query($sql);
	$sql="
		insert into quiz (que,ans_list,corr_ans,subject_code)
		values('which is your state?','mumbai_SePaRaTe_delhi_SePaRaTe_karnataka_SePaRaTe_tamil nadu',3,'gk00');
	";
	$conn->query($sql);
}

//----------------------student performance accourding to individual subjects
$sql = "create table user_subject
(
user VARCHAR(20),
user_id varchar(10) references login(user_id),
sub_code varchar(6) primary key,
tim varchar(10),
date varchar(10),
total INT(4),
attended INT(4),
right_ans INT(4),
ans_data varchar(200),
foreign key(sub_code) references subjects(sub_code),
);";
$conn->query($sql);
 echo "<script>alert('Initialization complete');history.go(-1);</script>";
?>