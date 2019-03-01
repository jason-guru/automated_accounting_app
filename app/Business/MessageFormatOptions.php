<?php

namespace App\Business;

use App\Models\MessageFormat;

class MessageFormatOptions
{
    public function select($code)
    {
        switch($code){
            case config('deadline.code.0'):
                return factory(MessageFormat::class)->create([
                    'name' => 'Annual Accounts Format',
                    'email_format' => 
                        '
                        Dear %mail_to,									
                                                
                        Your Annual Accounts for the year ended %period_to is due for submission on %due_on.									
                                                            
                        Please provide the following info to help us prepare the accounts to avoid any delay of unexpected penalties:									
                                                            
                        1	Bank statements from %period_from to %period_to								
                        2	Sales and expenses receipt from %period_from to %period_to								
                        3	Cash sales and expenses from %period_from to %period_to								
                                                            
                        If you have any questions on the above, feel free to call me on 07 9600 92100									
                                                            
                        Kind regards									
                        Nathan									
                        ',
                        'sms_format' => 
                        '
                        Dear %mail_to,									
                                            
                        Your Annual Accounts for the year ended %period_to is due for submission on %due_on.									
                                                            
                        Please provide the following info to help us prepare the accounts to avoid any delay of unexpected penalties:									
                                                            
                        1	Bank statements from %period_from to %period_to								
                        2	Sales and expenses receipt from %period_from to %period_to								
                        3	Cash sales and expenses from %period_from to %period_to								
                                                            
                        If you have any questions on the above, feel free to call me on 07 9600 92100									
                                                            
                        Kind regards									
                        Nathan									
                        
                        '
                ]);
            case config('deadline.code.1'):
            {
                return factory(MessageFormat::class)->create([
                    'name' => 'Confirmation Statement Format',
                    'email_format' => 
                        '
                        Dear %mail_to										
                                                    
                        Your Company Annual Confirmation statement need doing for the year ended %period_to. This is due for submission										
                        by %due_on and there is a fees to pay to Companies House.										
                                                                
                        If you want us to submit on you behalf please let us know and we will pay the fees to Companies House on your behalf										
                        and once filed we will invoive you £30.00 for the work. 										
                                                                
                        Let us know if you want us to file on your bahalf										
                                                                
                        Kind regards										
                        Nathan									
                        
                        ',
                        'sms_format' => 
                        "
                            Dear %mail_to										
                                                    
                            Your Company Annual Confirmation statement need doing for the year ended %period_to. This is due for submission										
                            by %due_on and there is a fees to pay to Companies House.										
                                                                    
                            If you want us to submit on you behalf please let us know and we will pay the fees to Companies House on your behalf										
                            and once filed we will invoive you £30.00 for the work. 										
                                                                    
                            Let us know if you want us to file on your bahalf										
                                                                    
                            Kind regards										
                            Nathan										
        
                        "
                ]);
            }
            case config('deadline.code.2'):
            {
                return factory(MessageFormat::class)->create([
                    'name' => 'VAT Format',
                    'email_format' => 
                        '
                        Dear %mail_to,									
                        Your Company VAT for the period %period_from to %period_to will be due for submission on %due_on									
                                                            
                        Please provide the following info at your earliest convenience so that we can prepare your VAT return on time									
                                                            
                            1	Bank statatment for the period %period_from to %period_to							
                            2	Expenses Invoices for the period %period_from to %period_to							
                            3	Sales Invoices for the period %period_from to %period_to							
                            4	Cash expenses and cash income if any for the period %period_from to %period_to							
                                                            
                        If you have already uploaded on Receipt bank all expenses and using our bookkeeping software for sales invoices									
                        then please ensure the info point 1 to 4 is updates in our system so that we can pick this info from there.									
                                                            
                        If you not using our software then please send this info to us at your earliest convenience.									
                                                            
                        Thanks and kind regards									
                        Nathan									
                        ',
                        'sms_format' => 
                        "
                        Dear %mail_to,									
                        Your Company VAT for the period %period_from to %period_to will be due for submission on %due_on									
                                                            
                        Please provide the following info at your earliest convenience so that we can prepare your VAT return on time									
                                                            
                            1	Bank statatment for the period %period_from to %period_to							
                            2	Expenses Invoices for the period %period_from to %period_to							
                            3	Sales Invoices for the period %period_from to %period_to							
                            4	Cash expenses and cash income if any for the period %period_from to %period_to							
                                                            
                        If you have already uploaded on Receipt bank all expenses and using our bookkeeping software for sales invoices									
                        then please ensure the info point 1 to 4 is updates in our system so that we can pick this info from there.									
                                                            
                        If you not using our software then please send this info to us at your earliest convenience.									
                                                            
                        Thanks and kind regards									
                        Nathan									
        
                        "
                ]);
            }
            case config('deadline.code.3'):  
            {
                return factory(MessageFormat::class)->create([
                    'name' => 'PAYE Format',
                    'email_format' => 
                        '
                        Dear %mail_to,							
							
                        Please provide payroll info for the period %period_from to %period_to to help us prepare the							
                        payroll							
                                                    
                        Thanks and kind regards							
                        Nathan							
                                                            
                        ',
                        'sms_format' => 
                        "
                        Dear %mail_to,							
							
                        Please provide payroll info for the period %period_from to %period_to to help us prepare the							
                        payroll							
                                                    
                        Thanks and kind regards							
                        Nathan							
                        "
                ]);
            }
            case config('deadline.code.4'):  
            {
                return factory(MessageFormat::class)->create([
                    'name' => 'CIS Format',
                    'email_format' => 
                        '
                        Dear %mail_to,							
							
                        Please provide CIS sub-contractor information if you have paid any sub-contractors for the period %period_from to %period_to to help us prepare the payroll							
                        Thanks and kind regards							
                        Nathan							
                        ',
                        'sms_format' => 
                        "
                        Dear %mail_to,							
							
                        Please provide CIS sub-contractor information if you have paid any sub-contractors for the period %period_from to %period_to to help us prepare the payroll							
                        Thanks and kind regards							
                        Nathan							
                        "
                ]);
            }
        }
    }
}