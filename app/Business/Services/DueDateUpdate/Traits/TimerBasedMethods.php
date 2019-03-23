<?php

namespace App\Business\Services\DueDateUpdate\Traits;
/**
 * Timer Based methods
 */
trait TimerBasedMethods
{
    public function timerBased()
    {
        $clients = $this->clientRepository->all();
        $clients->each(function($client){
            $this->client = $client;
            $deadlineTypes = collect([
                config('deadline.code.2'),
                config('deadline.code.3'),
                config('deadline.code.4')
            ]);
            $deadlineTypes->each(function($deadlineType){
                $this->deadline = $this->client->deadlines()->where('code', $deadlineType)->first();
                if(!is_null($this->deadline)){
                    $dueOnDate = carbon_parse($this->deadline->pivot->due_on);
                    $today = carbon_parse(Carbon::now());
                    if(!is_null($dueOnDate)){
                        if($dueOnDate <= $today){
                            $frequency = $this->clientDeadline->getFrequency($this->deadline->id, $this->client->id);
                            switch($frequency){
                                case 'Monthly':
                                    $nextDueDate = $this->monthly($dueOnDate);
                                    $this->update($nextDueDate);
                                    break;
                                case 'Quaterly':
                                    $nextDueDate = $this->quaterly($dueOnDate);
                                    $this->update($nextDueDate);
                                    break; 
                            }
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
            }
            });
        });
    }
}
