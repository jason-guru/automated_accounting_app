<?php
    
namespace App\Repositories\Backend\Traits\Methods;
 
/**
 * Common Due Calculator Methods
 */
trait CommonDueCalculatorMethods
{
    private function prepPath($path)
    {
        return explode(', ', $path);
    }
}
