<div class="card-header">
        <strong>Contact Info</strong>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Bussiness Start date</label>
                <input name="business_start_date" id="phone" type="text" placeholder="+44760092100" class="form-control" value="" required maxlength="13">
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input name="website" id="website" type="text" class="form-control" value="{{$client->website}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input name="email" id="email" type="email" class="form-control" value="{{$client->email}}" required placeholder="john@mail.com">
            </div>
        </div>
    </div>
</div>