<?php

namespace App\Models;

use App\Utilities\Calculator;
use App\Utilities\OutPutter;
use App\Utilities\Strings;

class Play
{
    private array $players = [];

    private OutPutter $outPutter;
    private Vehicles $vehicleModel;
    private Calculator $calculator;

    public function __construct()
    {
        $this->players[] = new Player("Player One");
        $this->players[] = new Player("Player Two");

        $this->calculator = new Calculator();
        $this->outPutter = OutPutter::getInstance();
        $this->vehicleModel = Vehicles::getInstance();
    }

    public function play(): void
    {
        $continue = true;

        while ($continue) {
            $this->printVehicleList();

            foreach ($this->players as $player) {
                $player->vehicle = $this->choseVehicleFromInput($player->name);
            }

            $distance = $this->outPutter->prompt(Strings::$QUESTION_INPUT_DISTANCE);

            foreach ($this->players as $player) {
                $player->arrivalTime = $this->calculator->calculateTime($player->vehicle, $distance);
            }

            $this->defineWinner();

            foreach ($this->players as $player) {
                $this->printPlayerTimeOfPlayer($player);
            }

            $continue = $this->askPlayAgain($this->outPutter);
        }
    }

    private function printVehicleList(): void
    {
        foreach ($this->vehicleModel->getVehicles() as $item => $vehicle) {

            $msg = sprintf(Strings::$VEHICLES_LIST_MESSAGE, $item + 1, $vehicle['name']);

            $this->outPutter->line($msg);
        }
    }

    private function choseVehicleFromInput($name)
    {
        $index = $this->outPutter->prompt(sprintf(Strings::$QUESTION_CHOSE_MESSAGE, $name, $this->vehicleModel->size()));

        return $this->vehicleModel->getVehicle($index);
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

    public function printPlayerTimeOfPlayer(Player $player): void
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
        $winningPlayer = null;

        foreach ($this->players as $player) {
            if ($winningPlayer === null || $player->arrivalTime->time < $winningPlayer->arrivalTime->time) {
                $winningPlayer = $player;
            }
        }

        return ($winningPlayer !== null) ? $winningPlayer->name : 'No One';
    }

    public function defineWinner(): void
    {
        $winner = $this->getWinnerPlayer();

        $this->outPutter->line(sprintf(Strings::$SHOW_WINNER_MESSAGE, $winner));
    }
}