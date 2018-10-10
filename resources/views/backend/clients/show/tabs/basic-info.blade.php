<div class="row">
<div class="col-md-6">
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>Company Number</th>
                <td>{{$client->company_number}}</td>
            </tr>
            <tr>
                <th>Company Name</th>
                <td>{{$client->company_name}}</td>
            </tr>
            <tr>
                <th>Company Type</th>
                <td>{{$client->company_type->name}}</td>
            </tr>
        </table>
    </div><!--table-responsive-->
</div>
<div class="col-md-6">
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>Accounts Next Due on</th>
                <td>{{Carbon\Carbon::parse($client->accounts_next_due)->format('d M, Y')}}</td>
            </tr>
            <tr>
                <th>Is Overdue</th>
                <td>{{$client->overdue == 0 ? 'No' : 'Yes'}}</td>
            </tr>
        </table>
    </div><!--table-responsive-->
</div>
</div>
    