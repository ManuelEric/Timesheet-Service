<table>
    <!-- header of timesheet start here -->
    <tr>
        <td height="100" valign="middle" align="center" colspan="8" style="font-size:20px; font-weight: bold;">
            @if ( $isGroup )
                Group Timesheet - {{ $packageDetails['program_name'] }}
                @php
                    $colspanBasicProfile = 4;
                @endphp
            @else
                Timesheet of {{ ucwords($clients['client_name']) }}
                @php
                    $colspanBasicProfile = 3;
                @endphp
            @endif
        </td>
    </tr>
    <!-- header of timesheet end here -->
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    
    <!-- basic profile start here -->
    <tr>
        <td colspan="{{ $colspanBasicProfile }}" align="center" style="font-weight: bold;">Basic Profile</td>
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

    <!-- package details start here -->
    <tr>
        <td colspan="3" align="center" style="font-weight: bold;">Package Details</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Type</td>
        <td align="center">:</td>
        <td>{{ $packageDetails['package_type'] }}</td>
        <td></td>
        <td></td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;" align="center">Total Minutes of Package</td>
    </tr>
    <tr>
        <td>Package</td>
        <td align="center">:</td>
        <td>{{ $packageDetails['package_name'] }}</td>
        <td></td>
        <td></td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;" align="center">{{ $packageDetails['duration_in_minutes'] }}</td>
    </tr>
    <tr>
        <td>Person in Charge</td>
        <td align="center">:</td>
        <td>{{ $packageDetails['pic_name'] }}</td>
        <td></td>
        <td></td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold; color: #0008fc;" align="center">Total Minutes Spent</td>
    </tr>
    <tr>
        <td>Mentor</td>
        <td align="center">:</td>
        <td>{{ $packageDetails['tutormentor_name'] }}</td>
        <td></td>
        <td></td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold; color: #0008fc;" align="center">{{ $packageDetails['time_spent_in_minutes'] }}</td>
    </tr>
    <tr>
        <td>In House</td>
        <td align="center">:</td>
        <td>{{ $packageDetails['inhouse_name'] }}</td>
        <td></td>
        <td></td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold; color: #fc0000;" align="center">Total Minutes Left</td>
    </tr>
    <tr>
        <td>Updated on</td>
        <td align="center">:</td>
        <td>{{ date('d F Y H:i', strtotime($packageDetails['last_updated'])) }}</td>
        <td></td>
        <td></td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold; color: #fc0000;" align="center">{{ $packageDetails['duration_in_minutes'] - $packageDetails['time_spent_in_minutes'] }}</td>
    </tr>
    <!-- Package Details end here -->

    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    
    <!-- Activities start here -->
    <tr height="35">
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">No</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Activity</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="70">Description</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Date</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Start (WIB)</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">End (WIB)</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Time spent<br>(minutes)</td>
    </tr>
    @foreach ( $activities as $activity )
    <tr>
        <td valign="middle" align="center" style="border: 1px solid #000;">{{ $loop->iteration }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['activity'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['description'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['date'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['start_time'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['end_time'] }}</td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">{{ $activity['estimate'] }}</td>
    </tr>
    @endforeach
    <!-- Activities end here -->
</table>
