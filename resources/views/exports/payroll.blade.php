<table>
    <!-- basic profile start here -->
    <tr>
        <td colspan="8" align="center" style="font-weight: bold;">Basic Profile</td>
    </tr>
    @if ($isGroup)
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
        @foreach ($clients as $client)
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
            <td>Program</td>
            <td align="center">:</td>
            <td>{{ $packageDetails['program_name'] }}</td>
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
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Fee</td>
        <td valign="middle" align="center" style="border: 1px solid #000; font-weight: bold;" width="15">Done?</td>
    </tr>
    @foreach ($activities as $activity)
        <tr>
            <td valign="middle" align="center" style="border: 1px solid #000;">{{ $loop->iteration }}</td>
            <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">
                {{ date('l', strtotime($activity['start_date'])) }}
            </td>
            <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">
                {{ date('Y-m-d', strtotime($activity['start_date'])) }}
            </td>
            <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">
                {{ $packageDetails['package_name'] }}
            </td>
            <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">
                {{ $activity['start_time'] }}
            </td>
            <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">
                {{ $activity['end_time'] }}
            </td>
            <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">
                {{ minutesToTimeFormat($activity['estimate']) }}
            </td>
            <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">
                {{ formatToRupiah($activity['fee_hours']) }}
            </td>
            <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">
                {{ $activity['status'] == 1 ? "done" : "-" }}
            </td>
        </tr>
    @endforeach
    <!-- Activities end here -->

    <!-- Total cut off date start here -->
    <tr>
        <td colspan="8" valign="middle" align="center"
            style="border: 1px solid #000; word-wrap: break-word; background-color: yellow; font-weight: bold;">CUT OFF
            DATE: {{ isset($cutoff) ? strtoupper(date('M d, Y', strtotime($cutoff->created_at))) : null }}</td>
    </tr>
    <!-- Total cut off date end here -->

    <!-- Total hour start here -->
    <tr>
        <td colspan="6" valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">Total hour
        </td>
        <td valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">
            {{ minutesToTimeFormat($total_hour) }}
        </td>
        <td style="border: 1px solid #000; word-wrap: break-word;"></td>
    </tr>
    <!-- Total hour end here -->

    <!-- Total fee without tax start here -->
    <tr>
        <td colspan="6" valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">Fee </td>
        <td valign="middle" align="right" style="border: 1px solid #000; word-wrap: break-word;">
            {{ formatToRupiah($total_fee_without_tax) }}
        </td>
        <td style="border: 1px solid #000; word-wrap: break-word;"></td>
    </tr>
    <!-- Total fee without tax end here -->

    <!-- Tax add here -->
    <tr>
        <td colspan="6" valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">Tax
            {{ $percentage_of_tax }}%
        </td>
        <td valign="middle" align="right" style="border: 1px solid #000; word-wrap: break-word;">
            {{ formatToRupiah($total_tax) }}
        </td>
        <td style="border: 1px solid #000; word-wrap: break-word;"></td>
    </tr>
    <!-- Tax end here -->

    <!-- Total fee start here -->
    <tr>
        <td colspan="6" valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">Total fee
        </td>
        <td valign="middle" align="right" style="border: 1px solid #000; word-wrap: break-word;">
            {{ formatToRupiah($total_fee) }}
        </td>
        <td style="border: 1px solid #000; word-wrap: break-word;"></td>
    </tr>
    <!-- Total fee end here -->

    <!-- Rounder start here -->
    <tr>
        <td colspan="6" valign="middle" align="center" style="border: 1px solid #000; word-wrap: break-word;">Pembulatan
        </td>
        <td valign="middle" align="right" style="border: 1px solid #000; word-wrap: break-word;">
            {{ formatToRupiah(roundCustom($total_fee)) }}
        </td>
    </tr>
    <!-- Rounder end here -->

</table>
