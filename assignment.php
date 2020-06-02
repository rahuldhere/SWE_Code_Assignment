<?php

   class Robot{
      private $batteryStatus;
      private $timeForRebotCharge;
      private $timeCleaningCounter;

      function __construct(){
         $this->batteryStatus = 100;
         $this->timeForRebotCharge = 0;
         $this->timeCleaningCounter = 0;
      }

      function showError($errorMsg){
         echo $errorMsg . PHP_EOL;
      }

      function cleanArea($floorName, $apartmentArea,$batteryStatus){
         $this->batteryStatus = $batteryStatus;
         echo "Floor Name : " . $floorName . PHP_EOL; 
         echo "Aparment Area : " . $apartmentArea . PHP_EOL; 
         echo "--------------------------------------------------------------" . PHP_EOL;
         while($this->cleaningAreaCovered <= $apartmentArea){
            if($this->batteryStatus > 0){
               echo "Cleaning Area Covered : " . $this->cleaningAreaCovered .' m.square'. PHP_EOL;
               echo "Curent Time Spend for Cleaning : " . $this->currentTimeSpend ." Second". PHP_EOL;
               echo "Battery Percentage Available : ". round($this->batteryStatus) ."%". PHP_EOL;
               echo "Robot Current State: ". $this->currentRobotState . PHP_EOL;
               echo "--------------------------------------------------------------" . PHP_EOL;

               if ($floorName == 'hard') {
                  $this->cleaningAreaCovered = $this->cleaningAreaCovered + 1;
               } else {
                  $this->cleaningAreaCovered = $this->cleaningAreaCovered + 0.5;
               }
               
               $this->currentTimeSpend = $this->currentTimeSpend+1;
               $this->timeCleaningCounter++;
               $this->batteryStatus = $this->timeCleaningCounter>0 ? (100 - (100/60) * $this->timeCleaningCounter) : 100;
            } else {
               $this->chargeBattery();
            }
            sleep(1);
         }
      }

      function chargeBattery(){
         if($this->timeForRebotCharge == 30){
            $this->batteryStatus = 100;
            $this->timeCleaningCounter = 0;
            $this->timeForRebotCharge = 0;
         } else {
            echo "Robot is in Charging State" . PHP_EOL;
            echo "--------------------------------------------------------------" . PHP_EOL;
            $this->currentTimeSpend = $this->currentTimeSpend+1; 
            $this->timeForRebotCharge++;
         }
         return $this->batteryStatus;
      }
   }

   class ApartmentOne extends Robot{
      public $floorName;
      public $apartmentArea;
      public $currentRobotState;
      public $cleaningAreaCovered;
      public $currentTimeSpend;

      function __construct($apartmentArea){
         $this->floorName = "hard";
         $this->apartmentArea = $apartmentArea;
         $this->currentRobotState = "Cleaning the floor";
         $this->cleaningAreaCovered = 0;
         $this->currentTimeSpend = 0;
      }
      function cleanApartOne(){
         $this ->cleanArea ($this->floorName,$this->apartmentArea,100,$this->currentRobotState,$this->cleaningAreaCovered,$this->currentTimeSpend);
      }
   }

   class ApartmentSecond extends Robot{
      public $floorName;
      public $apartmentArea;
      public $currentRobotState;
      public $cleaningAreaCovered;
      public $currentTimeSpend;
      function __construct($apartmentArea){
         $this->floorName = "carpet";
         $this->apartmentArea = $apartmentArea;
         $this->currentRobotState = "Cleaning the floor";
         $this->cleaningAreaCovered = 0;
         $this->currentTimeSpend = 0;
      }
      function cleanApartSecond(){
         $this ->cleanArea ($this->floorName,$this->apartmentArea,100,$this->currentRobotState,$this->cleaningAreaCovered,$this->currentTimeSpend);
      }
   }

   $inputParam = getopt("", ["floor:", "area:"]);

   $robotObject = new Robot();
   $aprtOneObject = new ApartmentOne($inputParam["area"]);
   $aprtSecondObject = new ApartmentSecond($inputParam["area"]);

   $floorNameParam = strtolower($inputParam["floor"]);

   if ($floorNameParam == 'carpet' ||  $floorNameParam== 'hard') {
      if (strtolower($inputParam["floor"]) == 'hard') {
         $aprtOneObject->cleanApartOne();
      } else {
         $aprtSecondObject->cleanApartSecond();
      }
   } else {
      $aprtOneObject->showError("Please make sure your floor should be either Carpet or Hard!!");
   }   

?>