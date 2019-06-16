<tr >
    <th> TÊN LIÊN HỆ </th>
    <th> EMAIL </th>
    <th> GIỚI TÍNH </th>
</tr>
@foreach($data as $value)
    <tr style="text-align: left">
        <td> {{$value['contact_name']}} </td>
        <td> {{$value['contact_email']}} </td>
        <td> {{$value['contact_gender']}} </td>
    </tr>
@endforeach
