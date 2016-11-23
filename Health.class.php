<?php
class Health{
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection=$mysqli;
	}


function savePeople ($Gender, $Age, $date, $NumberofSteps, $LandLength){
		
		//k�sk
		$stmt=$this->connection->prepare("INSERT INTO HealthCondition (Gender, Age, date, NumberofSteps, LandLength) VALUES(?,?,?,?,?)");
		
		$stmt->bind_param("siiii",$Gender, $Age, $date, $NumberofSteps, $LandLength);
		
		if($stmt->execute()) {
			echo "Salvestamine �nnestus";
			
		} else {
				echo "ERROR ".$stmt->error;
		
		}
			
	}
	
function getAllPeople () {
		
		//k�sk
		$stmt=$this->connection->prepare("
			SELECT id, Gender, Age, date, NumberofSteps, LandLength
			FROM HealthCondition
		");
		echo $this->connection->error;
		$stmt->bind_result($id, $Gender, $Age, $date, $NumberofSteps, $LandLength);
		$stmt->execute();
		
		//array("Marii", "M")
		$result=array();
		//seni kuni on �ks rida andmeid saada (10 rida=10 korda)
		while($stmt->fetch()) {
			$person=new StdClass();
			$person->id=$id;
			$person->Gender=$Gender;
			$person->Age=$Age;
			$person->date=$date;
			$person->NumberofSteps=$NumberofSteps;
			$person->LandLength=$LandLength;
			
			//echo $Color."<br>";
			array_push($result, $person);
		}
		$stmt->close();
		$this->connection->close();
		
		return $result;

	}	
}
?>