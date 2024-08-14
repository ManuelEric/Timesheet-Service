<table>
    <!-- basic profile start here -->
    <tr>
        <td colspan="8" align="center" style="font-weight: bold;">Basic Profile</td>
    </tr>
    @if ( $isGroup )
        <tr height="25">
            <td valign="middle" align="center">No</td>
            <td valign="middle" align="center">Student Name</td>
            <td valign="middle" align="center">School</td>
            <td valign="middle" align="center">Grade</td>
            <td valign="middle" align="center" colspan="2">Email</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @foreach ( $clients as $client )
        <tr>
            <td valign="middle" align="center" style="word-wrap: break-word;">{{ $loop->iteration }}</td>
            <td valign="middle" align="center" style="word-wrap: break-word;">{{ $client['client_name'] }}</td>
            <td valign="middle" align="center" style="word-wrap: break-word;">{{ $client['client_school'] }}</td>
            <td valign="middle" align="center" style="word-wrap: break-word;">{{ $client['client_grade'] }}</td>
            <td valign="middle" align="center" colspan="2">{{ $client['client_mail'] }}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @endforeach
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
    @else
    <tr>
        <td>Student Name</td>
        <td align="center">:</td>
        <td>{{ $clients['client_name'] }}</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>School</td>
        <td align="center">:</td>
        <td>{{ $clients['client_school'] }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Grade</td>
        <td align="center">:</td>
        <td align="left">{{ $clients['client_grade'] }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Email</td>
        <td align="center">:</td>
        <td>{{ $clients['client_mail'] }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    @endif
    <!-- basic profile end here -->

    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>

    <!-- Activities start here -->
    <tr height="35">
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">No</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Day</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="70">Date</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Session</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Start Time</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">End Time</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Duration</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Done?</td>
    </tr>
    @foreach ( $activities as $activity )
    <tr>
        <td valign="middle" align="center" style="border: 1px solid #000;">{{ $loop->iteration }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ date('l', strtotime($activity['start_date'])) }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['start_date'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $packageDetails['package_name'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['start_time'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['end_time'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['estimate'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['status'] }}</td>
    </tr>
    @endforeach
    <!-- Activities end here -->
</table>
