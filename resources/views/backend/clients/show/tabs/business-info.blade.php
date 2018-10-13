<div class="row">
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr class='{{$client->company_type_id == 6 ? "d-none" : ""}}'>
                    <th>Business Start Date</th>
                    <td>{{Carbon\Carbon::parse($client->business_info->business_start_date)->format('d-m-Y')}}</td>
                </tr>
                <tr class='{{$client->company_type_id == 6 ? "d-none" : ""}}'>
                    <th>Book Start Date</th>
                    <td>{{Carbon\Carbon::parse($client->business_info->book_start_date)->format('d-m-Y')}}</td>
                </tr>
                <tr class='{{$client->company_type_id == 6 ? "d-none" : ""}}'>
                    <th>Year End Date</th>
                    <td>{{Carbon\Carbon::parse($client->business_info->year_end_date)->format('d-m-Y')}}</td>
                </tr>
                <tr>
                    <th>Last Bookkeeping Done</th>
                    <td>{{Carbon\Carbon::parse($client->business_info->last_bookkeeping_done)->format('d-m-Y') }}</td>
                </tr>
                <tr class="{{$client->company_type_id == 2 || $client->company_type_id == 3 || $client->company_type_id == 4 || $client->company_type_id == 6  || $client->company_type_id == 7 ? "d-none" : ""}}">
                    <th>Company Registration Number</th>
                    <td>{{$client->business_info->company_reg_number}}</td>
                </tr>
                <tr>
                    <th>Social Media</th>
                    <td>{{$client->business_info->social_media}}</td>
                </tr>
            </table>
        </div><!--table-responsive-->
    </div>
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>UTR</th>
                    <td>{{$client->business_info->utr}}</td>
                </tr>
                <tr>
                    <th>UTR Number</th>
                    <td>{{$client->business_info->utr_number}}</td>
                </tr>
                <tr class='{{$client->company_type_id == 6 ? "d-none" : ""}}'>
                    <th>Vat Scheme</th>
                    <td>{{isset($client->business_info->vat_scheme->name) ? $client->business_info->vat_scheme->name : null }}</td>
                </tr>
                <tr class='{{$client->company_type_id == 6 ? "d-none" : ""}}'>
                    <th>Vat Registration Number</th>
                    <td>{{$client->business_info->vat_reg_number}}</td>
                </tr>
                <tr class='{{$client->company_type_id == 6 ? "d-none" : ""}}'>
                    <th>Vat Submit Type</th>
                    <td>{{isset($client->business_info->vat_submit_type->name) ? $client->business_info->vat_submit_type->name : null }}</td>
                </tr>
                <tr class='{{$client->company_type_id == 6 ? "d-none" : ""}}'>
                    <th>Vat Registration Date</th>
                    <td>{{Carbon\Carbon::parse($client->business_info->vat_reg_date)->format('d-m-Y')}}</td>
                </tr>
            </table>
        </div><!--table-responsive-->
    </div>
    </div>
        