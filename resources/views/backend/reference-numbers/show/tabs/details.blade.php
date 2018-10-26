<div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>Name:</th>
                        <td>{{$reference_number->name}}</td>
                    </tr>
                    <tr>
                        <th>Company Name:</th>
                        <td>{{$reference_number->client->company_name}}</td>
                    </tr>
                    <tr>
                        <th>Reference Number</th>
                        <td>{{$reference_number->reference_number}}</td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>£{{number_format($reference_number->amount, 2)}}</td>
                    </tr>
                    <tr>
                        <th>Attachment</th>
                        <td><a href="{{!is_null($reference_number->attachment_path) ? asset('storage/'.$reference_number->attachment_path): '#'}}">Click here to download</a>
                        @if(is_null($reference_number->attachment_path))
                        <small class="form-text text-muted">No file attached</small>
                        @endif
                    </td>
                    </tr>
                </table>
            </div><!--table-responsive-->
        </div>
    </div>