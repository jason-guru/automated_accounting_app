<div class="row">
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Address Line 1</th>
                    <td>{{$client->address_line_1}}</td>
                </tr>
                <tr>
                    <th>Address Line 2</th>
                    <td>{{$client->address_line_2}}</td>
                </tr>
                <tr>
                    <th>Post Code</th>
                    <td>{{$client->postcode}}</td>
                </tr>
            </table>
        </div><!--table-responsive-->
    </div>
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>City</th>
                    <td>{{$client->city}}</td>
                </tr>
                <tr>
                    <th>County</th>
                    <td>{{$client->county}}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{$client->country->name}}</td>
                </tr>
            </table>
        </div><!--table-responsive-->
    </div>
</div>