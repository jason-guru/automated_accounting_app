<tr>
    <td>{{$form_data['first_name']}} <input type="hidden" name="first_name[]" value="{{$form_data['first_name']}}"></td>
    <td>{{$form_data['contact_phone']}} <input type="hidden" name="contact_phone[]" value="{{$form_data['contact_phone']}}"></td>
    <td>{{$form_data['contact_email']}} <input type="hidden" name="contact_email[]" value="{{$form_data['contact_email']}}"></td>
    <input type="hidden" name="designation_id[]" value="{{$form_data['designation_id']}}">
    <input type="hidden" name="initial_id[]" value="{{$form_data['initial_id']}}">
    <input type="hidden" name="middle_name[]" value="{{$form_data['middle_name']}}">
    <input type="hidden" name="last_name[]" value="{{$form_data['last_name']}}">
    <input type="hidden" name="contact_address_line_1[]" value="{{$form_data['contact_address_line_1']}}">
    <input type="hidden" name="contact_address_line_2[]" value="{{$form_data['contact_address_line_2']}}">
    <input type="hidden" name="contact_city[]" value="{{$form_data['contact_city']}}">
    <input type="hidden" name="contact_postcode[]" value="{{$form_data['contact_postcode']}}">
    <input type="hidden" name="contact_county[]" value="{{$form_data['contact_county']}}">
    <input type="hidden" name="contact_country_id[]" value="{{$form_data['contact_country_id']}}">
</tr>