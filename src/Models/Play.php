<?php

namespace App\Models;

use App\Utilities\Calculator;
use App\Utilities\OutPutter;
use App\Utilities\Strings;

class Play
{
    private Player $playerOne;
    private Player $playerTwo;
    private OutPutter $outPutter;
    private Vehicles $vehicleModel;
    private Calculator $calculator;

    public function __construct()
    {
        $this->playerOne = new Player();
        $this->playerTwo = new Player();

        $this->playerOne->name = "Player One";
        $this->playerTwo->name = "Player Two";

        $this->calculator = new Calculator();
        $this->outPutter = OutPutter::getInstance();
        $this->vehicleModel = Vehicles::getInstance();
    }

    public function play(): void
    {
        $continue = true;

        while ($continue) {
            $this->printVehicleList($this->vehicleModel->getVehicles());

            $this->playerOne->vehicle = $this->getVehicle($this->outPutter, $this->vehicleModel);
            $this->playerTwo->vehicle = $this->getVehicle($this->outPutter, $this->vehicleModel);

            $distance = $this->outPutter->prompt(Strings::$QUESTION_INPUT_DISTANCE);

            $this->playerOne->arrivalTime = $this->calculator->calculateTime($this->playerOne->vehicle, $distance);
            $this->playerTwo->arrivalTime = $this->calculator->calculateTime($this->playerTwo->vehicle, $distance);

            $winner = $this->getWinnerPlayer();

            $this->outPutter->line(sprintf(Strings::$SHOW_WINNER_MESSAGE, $winner));

            $this->printPlayerTime($this->playerOne);
            $this->printPlayerTime($this->playerTwo);

            $continue = $this->askPlayAgain($this->outPutter);
        }
    }

    private function printVehicleList($vehicles): void
    {
        foreach ($vehicles as $item => $vehicle) {

            $msg = sprintf(Strings::$VEHICLES_LIST_MESSAGE, $item, $vehicle['name']);

            $this->outPutter->line($msg);
        }
    }

    private function getVehicle(OutPutter $outPutter, $vehicleModel)
    {
        $index = $outPutter->prompt(sprintf(Strings::$QUESTION_CHOSE_MESSAGE, 'One', ($vehicleModel->size() - 1)));

        return $vehicleModel->getVehicle($index);
    }

    private function askPlayAgain(OutPutter $outPutter): bool
    {
        $playAgain = $outPutter->choose(question: Strings::$QUESTION_PLAY_AGAIN);

        $outPutter->line($playAgain);
        if ($playAgain === "n") {
            return false;
        } else {
            foreach (range(0, 2) as $item) {
                $outPutter->line('');
            }
            $outPutter->line('-------------------------| New Game |----------------------');
        }

        return true;
    }

    public function printPlayerTime(Player $player): void
    {
        $message = sprintf(Strings::$SHOW_PLAYER_TIME,
            $player->name,
            $player->arrivalTime->hours,
            $player->arrivalTime->minutes
        );

        $this->outPutter->line($message);
    }

    public function getWinnerPlayer(): string
    {
        return ($this->playerOne->arrivalTime->time < $this->playerTwo->arrivalTime->time) ? $this->playerOne->name : (
        ($this->playerTwo->arrivalTime->time < $this->playerOne->arrivalTime->time) ? $this->playerTwo->name : 'No One'
        );
    }
}